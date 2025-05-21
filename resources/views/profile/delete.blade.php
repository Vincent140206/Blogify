@extends('layouts.app')

@section('content')
    <h2>Hapus Akun</h2>

    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    <form action="{{ route('account.delete') }}" method="POST">
        @csrf
        @method('DELETE')

        <label for="password">Masukkan Password untuk konfirmasi:</label>
        <input type="password" name="password" required>

        <button type="submit" style="color: red">Hapus Akun</button>
    </form>
@endsection
