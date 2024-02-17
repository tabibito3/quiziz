@extends('user.layouts.main')
@section('title', 'Share')
@section('content')
    <style>
        .time {
            font-size: 11px !important
        }

        .socials i {
            margin-right: 14px;
            font-size: 17px;
            color: #d2c8c8;
            cursor: pointer
        }

        .feed-image img {
            width: 100%;
            height: auto
        }

        a {
            text-decoration: none;
        }
    </style>

    @push('css')
        @livewireStyles
    @endpush

    @push('js')
        @livewireScripts
    @endpush

    <div class="container mt-4 mb-5">
        <div class="d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="feed p-2">
                    <div class="p-2 bg-white border">
                        <div class="feed-text px-2">
                            <h6 class="text-black-50 mt-2">Share Your Result!</h6>
                            <hr>
                            <form action="{{ route('share.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3 col-9">
                                    <div class="col-3">
                                        <h6 class="mb-0">Upload Image</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3 col-9">
                                    <div class="col-3">
                                        <h6 class="mb-0">Description</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <textarea name="description" class="form-control" rows="5" placeholder="">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary">Send
                                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="m4.01 6.03l7.51 3.22l-7.52-1zm7.5 8.72L4 17.97v-2.22zM2.01 3L2 10l15 2l-15 2l.01 7L23 12z" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @forelse ($data as $posts)
                    <div class="bg-white border mt-2">
                        <div>
                            <div class="d-flex flex-row justify-content-between align-items-center p-2 border-bottom">
                                <div class="d-flex flex-row align-items-center feed-text px-2">
                                    <img class="rounded-circle" src="{{ $posts->user->photo ? asset('storage/' . $posts->user->photo) : asset('default.png') }}"
                                        height="45" width="45">

                                    <div class="d-flex flex-column flex-wrap ml-2 px-3">
                                        <span class="font-weight-bold">{{ $posts->user->name }}</span>
                                        <span class="text-black-30 time">{{ $posts->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="feed-image p-2 px-3">
                            <img class="img-fluid img-responsive" src="{{ asset('storage/' . $posts->image) }}">
                        </div>
                        <div class="p-2 px-3">
                            Description :
                            <span>{{ $posts->description }}</span>
                        </div>
                        <div class="d-flex justify-content-end socials p-2 py-3">
                            <i class="fa fa-thumbs-up text-primary">
                                <small>10</small>
                            </i>
                            <a href="#comments_section{{ $posts->id }}" data-bs-toggle="collapse">
                                <i class="fa fa-comments"></i>
                            </a>
                        </div>
                        <div class="collapse" id="comments_section{{ $posts->id }}">
                            @livewire('posts.comment', ['id' => $posts->id])
                        </div>

                    </div>
                @empty
                <div class="d-flex justify-content-center">
                    <div class="text-center col-lg-8">
                        <img src="{{ asset('no-data.jpg') }}" alt="no-data" class="img-fluid">
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

@endsection
