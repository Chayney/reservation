@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_import.css') }}">
@endsection

@section('content')
    <h2 class="title">新規店舗追加</h2>
    <div class="explanation-content">
        <p class="explanation-text">csvをインポートすることで、店舗情報を追加することができます</p>
        <p class="explanation-text">※画像URLはjpg,jpeg、pngのみアップロード可能です</p>
        <p class="explanation-text">※店舗情報の上書きではなく新規店舗を追加するための機能です</p>
    </div>
    <form action="/admin/import/csv" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="csvFile" accept=".csv" class="input-file" required>
        <button type="submit" class="input-button">インポート</button>
    </form>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('errors'))
        <div class="alert alert-error">
            @foreach (session('errors') as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif
@endsection