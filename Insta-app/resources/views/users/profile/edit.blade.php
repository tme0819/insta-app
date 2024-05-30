@extends('layouts.app')

@section('title', $user->name)

@section('content')
{{ session_start() }}
<div class="row border shadow justify-content-center mb-4">
    <div class="card border-0 p-5">
        <h2 class="mt-4">Update Profile</h2>
        <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data" class="">
            @csrf
            @method('PATCH')
            <div class="row mb-3">
                <div class="col-4">
                    @if ($user->avatar)
                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle d-block mx-auto avatar-lg">
                    @else
                        <i class="fa-solid fa-circle-user text-secondary d-block mx-auto text-center icon-lg"></i>
                    @endif
                    
                </div>
                <div class="col-4 mt-5">
                    <input type="file" name="avatar" id="avatar" class="form-control mt-1" aria-describedby="avatar-info">
                <div class="form-text" id="avatar-info">
                    Acceptable formats are jpeg, jpg, png, and gif only <br>
                    Maximum file size: 1048kb.
                </div>
                {{-- error --}}
                @error('avatar')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name)}}" class="form-control bg-light" autofocus>
            </div>
            {{-- ERROR --}}
            @error('name')
                <p class="text-danger small">{{ $message }}</p>
            @enderror

            <div class="mb-3">
                <lable for="email" class="form-label fw-bold">E-mail Address</lable>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
            </div>
            {{-- ERROR --}}
            @error('email')
                <p class="text-danger small">{{ $message }}</p>
            @enderror

            <div class="mb-3">
                <label for="introduction" class="form-label fw-bold">Introduction</label>
                <textarea name="introduction" id="introduction" cols="30" rows="5" class="form-control" placeholder="Describe yourself...">{{ old('introduction', $user->introduction) }}</textarea>
            </div>
            {{-- ERROR --}}
            @error('introduction')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
            
            <button type="submit" class="btn btn-warning mb-5 save px-5">Save</button>
        </form>
    </div>
</div>
<div class="row border shadow justify-content-center">
    <div class="card border-0 p-5">
        <h2 class="mt-4 mb-4">Update Password</h2>
        <form action="{{ route('profile.passwordupdate') }}" method="post">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="oldpassword" class="form-label fw-bold">Current Password</label>
                <input type="password" name="oldpassword" class="form-control bg-light">
            </div>
            {{-- ERROR --}}
            @if (session('current_password_error'))
                <p class="text-danger small">{{ session('current_password_error') }}</p>
            @endif
            @error('oldpassword')
                <p class="text-danger small">{{ $message }}</p>
            @enderror

            <div class="mb-3">
                <label for="newpassword" class="form-label fw-bold">New Password</label>
                <input type="password" name="newpassword" class="form-control bg-light">
            </div>
            {{-- ERROR --}}
            @if (session('new_password_error'))
                <p class="text-danger small">{{ session('new_password_error') }}</p>
            @endif
            @error('newpassword')
                <p class="text-danger small">{{ $message }}</p>
            @enderror

            <div class="mb-3">
                <label for="confirm" class="form-label fw-bold">Confirm Password</label>
                <input type="password" name="confirm" class="form-control bg-light">
            </div>
            {{-- ERROR --}}
            @error('confirm')
                <p class="text-danger small">{{ $message }}</p>
            @enderror

            <button type="submit" class="btn btn-warning mb-5 save px-5">Update Password</button>
        </form>
    </div>
</div>
    
@endsection