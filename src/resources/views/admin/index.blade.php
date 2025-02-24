@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/admin_index.css') }}">
@endsection

@section('content')
  <div class="admin__content">
    <div class="admin-form__heading">
      <h1>管理者専用ページ</h1>
    </div>
    <div class="link">
      <a class="button-submit" href="/admin/review">コメント一覧</a>
    </div>
    <div class="link">
      <a class="button-submit" href="/admin">お知らせメール作成・送信</a>
    </div>
  </div>
@endsection