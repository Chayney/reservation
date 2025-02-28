@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review_done.css') }}">
@endsection

@section('content')
  <div class="contact-form__content">
    <div class="center__container">
      <h2>口コミを投稿しました<br>ありがとうございました</h2>
      <a href="{{ url('/') }}">戻る</a>
    </div>
  </div>
@endsection
