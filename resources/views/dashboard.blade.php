@extends('layouts.app')

@section('content')
    <h1>Selamat datang di Dashboard!</h1>
    <p>Kamu berhasil login 🎉</p>

    <p>Halo, {{ Auth::user()->name }}!</p>

    <form action="/logout" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <p>Ingin ganti password? <a href="{{ route('password.change') }}">Ganti di sini</a></p>
@endsection
