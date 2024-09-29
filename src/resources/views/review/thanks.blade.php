@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
  <div class="contact-form__content">
    <div class="center__container">
      <h2>レビューを投稿しました<br>ありがとうございました</h2>
      <a href="/detail/{{ $shop['id'] }}">戻る</a>
    </div>
  </div>
@endsection
