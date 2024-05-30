@extends('layouts.app')

@section('title', 'Suggested Users')

@section('content')
    <div class="row justify-content-center ">
        <div class="col-5 shadow rounded-3 p-4">
            <h3 class="text-center mt-4 mb-4">Suggested</h4>

            @foreach ($suggested_users as $user)
            <div class="row align-items-center mb-3">
                {{-- avatar --}}
                    <div class="col-auto">
                        <a href="{{ route('profile.show', $user->id) }}">
                            @if ($user->avatar)
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle avatar-md">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                            @endif
                        </a>
                    </div>

                    {{-- name & email --}}
                    <div class="col ps-0 text-truncate">
                        <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">
                            {{ $user->name }}
                        </a>
                            <p class="text-muted mb-0 small">{{ $user->email }}</p>
                            <p class="text-muted mb-0 small">{{ $user->followers->count() }} {{ $user->followers->count() == 1 ? 'follower' : 'followers'}}</p> 
                    </div>

                    {{-- Follow button --}}
                    <div class="col text-end">
                        <form action="{{ route('follow.store', $user->id)}}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary fw-bold">
                                Follow
                            </button>
                        </form>
                    </div>
            </div>
            
                
            @endforeach
        </div>
    </div>
@endsection