@extends('layouts.app')

@section('title', 'Show Post')

@section('content')
<style>
    .col-4{
        overflow-y: scroll;
    }

    .card-body{
        position: absolute;
        top: 65px;
    }
</style>
    <div class="row border shadow">
        <div class="col p-0 border-end">
            <img src="{{ $post->image}}" alt="Post ID {{ $post->id }}" class="w-100">
        </div>
        <div class="col-4 px-0 bg-white">
            <div class="card border-0">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        {{-- avatar of the owner --}}
                        <div class="col-auto">
                            <a href="{{ route('profile.show', $post->user->id) }}">
                                @if ($post->user->avatar)
                                    <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>
                        {{-- name of the owner --}}
                        <div class="col ps-0">
                            <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark">
                                {{ $post->user->name }}
                            </a>
                        </div>
                        <div class="col-auto">
                            @if (Auth::user()->id === $post->user->id)
                                {{-- Edit or Delete --}}
                                <div class="dropdown">
                                    <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>

                                    <div class="dropdown-menu">
                                        {{-- edit --}}
                                        <a href="{{ route('post.edit', $post->id) }}" class="dropdown-item">
                                            <i class="fa-regular fa-pen-to-square"></i> Edit
                                        </a>
                                        {{-- delete --}}
                                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-post-{{ $post->id }}">
                                            <i class="fa-regular fa-trash-can"></i> Delete
                                        </button>
                                    </div>
                                     {{-- include modal here --}}
                                     @include('users.posts.contents.modals.delete')
                                </div>
                            @else
                                
                                @if ($post->user->isFollowed())
                                    {{-- Unfollow button --}}
                                    <form action="{{ route('follow.destroy', $post->user_id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="border-0 bg-transparent p-0 text-secondary">
                                            Following
                                        </button>
                                    </form>
                                @else
                                    {{-- Follow button --}}
                                    <form action="{{ route('follow.store', $post->user_id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="border-0 bg-transparent p-0 text-primary">
                                            Follow
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body w-100">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            @if ($post->isLiked())
                            <form action="{{ route('like.destroy', $post->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm shadow-none p-0"><i class="fa-solid fa-heart text-danger"></i></button>
                            </form>
                            @else
                                <form action="{{ route('like.store', $post->id) }}" method="post">
                                    @csrf
                
                                    <button type="submit" class="btn btn-sm shadow-none p-0"><i class="fa-regular fa-heart"></i></button>
                                </form>
                            @endif
                        </div>
                        <div class="col-auto px-0">
                            <span>{{ $post->likes->count() }}</span>
                        </div>
                        <div class="col text-end">
                            @foreach ($post->categoryPost as $category_post)
                                <div class="badge bg-secondary bg-opacity-50">
                                    {{ $category_post->category->name}}
                                </div>
                            @endforeach
                        </div>
                    </div>
                
                        {{-- Owner + description --}}
                        <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $post->user->name }}</a>
                        &nbsp;
                        <p class="d-inline fw-light">{{ $post->description }}</p>
                        <p class="text-uppercase text-muted xsmall">{{ date('M d, Y', strtotime($post->created_at)) }}</p>

                        {{--Comments --}}
                        <div class="mt-4">
                            <form action="{{ route('comment.store', $post->id)}}" method="post">
                                @csrf
                                
                                <div class="input-group">
                                    <textarea name="comment_body{{ $post->id }}" id="" cols="30" rows="1" class="form-control form-control-sm" placeholder="Add a comment...">{{ old('comment_body' . $post->id ) }}</textarea>
                                    <button class="btn btn-outline-secondary btn-sm" title="Post"><i class="fa-solid fa-paper-plane"></i></button>
                                </div>
                                {{-- Error --}}
                                @error('comment_body' . $post->id)
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </form>
                        {{-- Show all comments here --}}
                        @if ($post->comments->isNotEmpty())
                            <ul class="list-group mt-2">
                                @foreach ($post->comments as $comment)
                                    <li class="list-group-item border-0 p-0 mb-2">
                                        <a href="{{ route('profile.show', $comment->user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $comment->user->name }}</a>
                                        &nbsp;
                                        <p class="d-inline fw-light">{{ $comment->body }}</p>

                                        <form action="{{ route('comment.delete', $comment->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <span class="text-uppercase text-muted xsmall">{{ date('M d, Y', strtotime($comment->created_at)) }}</span>

                                            {{-- If the auth user is owner of the comment show a delete button --}}
                                            @if (Auth::user()->id === $comment->user->id)
                                                &middot;
                                                <button class="border-0 bg-transparent text-danger p-0 xsmall">Delete</button>                                               
                                            @endif
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        </div>

                </div>
            </div>
        </div>
    </div>
@endsection