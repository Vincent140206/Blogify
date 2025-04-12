@extends('layouts.app')

@section('content')
    <h1>Ganti Password</h1>

    {{-- Notifikasi --}}
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('password.change') }}" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
        @csrf

        <div>
            <label for="old_password">Password Lama:</label>
            <input type="password" name="current_password" id="current_password" required style="width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ccc;">
        </div>

        <div>
            <label for="new_password">Password Baru:</label>
            <input type="password" name="new_password" id="new_password" required style="width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ccc;">
        </div>

        <div>
            <label for="confirm_password">Konfirmasi Password:</label>
            <input type="password" name="new_password_confirmation" id="new_password_confirmation" required style="width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ccc;">
        </div>

        <button type="submit" class="btn">Ubah Password</button>
    </form>
@endsection