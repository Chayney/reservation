@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
  <div class="contact-form__content">
    <div class="center__container">
      <h2>ご予約ありがとうございます</h2>
      <a href="{{ url('/') }}">戻る</a>
    </div>
  </div>
@endsection
