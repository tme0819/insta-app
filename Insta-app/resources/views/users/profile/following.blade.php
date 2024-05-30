@extends('layouts.app')

@section('title', 'Following')

@section('content')
@include('users.profile.header')

<div style="margin-top: 100px">
    @if ($user->following->isNotEmpty())
        <div class="row justify-content-center">
            <div class="col-4">
                <h3 class="text-muted text-center">Following</h3>

                @foreach ($user->following as $followingUser)
                    <div class="row align-items-center mt-3">
                        {{-- Avatar --}}
                        <div class="col-auto">
                            <a href="{{ route('profile.show', $followingUser->following_id)}}">
                                @if ($followingUser->following->avatar)
                                    <img src="{{ $followingUser->following->avatar }}" alt="{{ $followingUser->following->name}}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>

                        {{-- name --}}
                        <div class="col ps-0 text-truncate">
                            <a href="{{ route('profile.show', $followingUser->following->id) }}" class="text-decoration-none text-dark fw-bold">
                                {{ $followingUser->following->name}}
                            </a>
                        </div>

                        {{-- follow/following button --}}
                        <div class="col-auto text-end">
                            @if ($followingUser->following->id != Auth::user()->id)
                                @if ($followingUser->following->isFollowed())
                                    {{-- unfollow user --}}
                                    <form action="{{ route('follow.destroy', $followingUser->following->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn-sm border-0 bg-transparent p-0 text-secondary">
                                            Following
                                        </button>
                                    </form>
                                @else
                                    {{-- follow user --}}
                                    <form action="{{ route('follow.store', $followingUser->following->id)}}" method="post">
                                        @csrf
                                        <button type="submit" class="border-0 bg-transparent p-0 text-primary btn-sm">
                                            Follow
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <h3 class="text-muted text-center">No Following yet</h3>
    @endif
</div>
@endsection