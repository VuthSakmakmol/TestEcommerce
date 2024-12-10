@extends('layouts.app')

@section('content')
    <h1>Edit Profile</h1>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email') <span>{{ $message }}</span> @enderror
        </div>

        <button type="submit">Update</button>
    </form>
@endsection
