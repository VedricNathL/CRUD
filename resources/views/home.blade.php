@extends('layouts.layout')

@section('content')
    <div class="jumbotron py-4 px-5">
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if (Session::get('failed'))
            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
        @endif
        <h1 class="display-4">
            Selamat Datang {{ Auth::user()->name}}!
        </h1>
        <hr class="my-4">
        <p>Aplikasi ini digunakan hanya oleh pegawai administraor APOTEK. digunakan untuk mengelola data obat, penyetokan & kasir</p>
    </div>
@endsection
