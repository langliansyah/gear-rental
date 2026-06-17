@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="container">
    <h1>Selamat datang, {{ Auth::user()->full_name }}!</h1>
    <p>Ini halaman pelanggan.</p>
    
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
</div>
@endsection