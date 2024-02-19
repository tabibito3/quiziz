<?php

namespace App\Livewire\Posts;

use App\Models\Comment as ModelsComment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Comment extends Component
{
    public $post, $body, $update_body;
    public $edit_comment_id;

    public function mount($id)
    {
        $this->post = Post::find($id);
    }

    public function render()
    {

        return view('livewire.posts.comment', [
            'comments' => ModelsComment::with('user')->where('post_id', $this->post->id)->latest()->get(),
            'total_comments' => ModelsComment::where('post_id', $this->post->id)->count(),
        ]);
    }

    public function store()
    {
        $this->validate(['body' => 'required']);
        $comment = ModelsComment::create([
            'user_id' => Auth::user()->id,
            'post_id' => $this->post->id,
            'body' => $this->body
        ]);

        if ($comment) {
            $this->body = null;
        }
    }

    public function selectEdit($id)
    {
        $comment = ModelsComment::find($id);
        $this->edit_comment_id = $comment->id;
        $this->update_body = $comment->body;
    }

    public function cancelEdit()
    {
        // Reset data atau melakukan aksi pembatalan lainnya
        $this->edit_comment_id = null;
        $this->update_body = '';

    }


    public function update()
    {
        $this->validate(['update_body' => 'required']);

        $comment = ModelsComment::where('id', $this->edit_comment_id)->update([
            'body' => $this->update_body
        ]);

        if ($comment) {
            $this->body = NULL;
            $this->edit_comment_id = NULL;
        } else {
            session()->flash('error', 'Komentar gagal diubah');
        }
    }

    public function delete($id)
    {
        $comment = ModelsComment::where('id', $id)->delete();

        if ($comment) {
            return NULL;
        } else {
            session()->flash('error', 'Komentar gagal dihapus');
        }
    }


    public function like($id)
    {
        $data = [
            'comment_id' => $id,
            'user_id' => Auth::user()->id
        ];

        $like = Like::where($data);

        if ($like->count() > 0) {
            $like->delete();
        } else {
            Like::create($data);
        }

        return NULL;
    }
}
