@extends('layouts.app')

@section('content')
<h2>Form Login</h2>

{{-- Notifikasi sukses --}}
@if (session('success'))
<div style="color: green;">
    {{ session('success') }}
</div>
@endif

{{-- Tampilkan error validasi --}}
@if ($errors->any())
<div style="color: red;">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- Form login --}}
<form method="POST" action="{{ route('login') }}" style="display: flex; flex-direction: column; gap: 1rem; max-width: 400px;">
    @csrf

    <div>
        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" required style="width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ccc;">
    </div>

    <div>
        <label for="password">Password:</label><br>
        <input type="password" name="password" id="password" required
            style="width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ccc;">

        <div style="margin-top: 0.5rem;">
            <input type="checkbox" id="showPassword" onclick="togglePassword()">
            <label for="showPassword">Lihat Password</label>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const showPassword = document.getElementById('showPassword');
            passwordInput.type = showPassword.checked ? 'text' : 'password';
        }
    </script>

    <button type="submit" class="btn">Login</button>
</form>

<p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
@endsection