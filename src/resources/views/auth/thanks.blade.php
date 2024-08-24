@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
  <div class="contact-form__content">
      <div class="center__container">
          <h2>会員登録ありがとうございます</h2>
          <a href="{{ url('login') }}">ログインする</a>
      </div>
  </div>
@endsection
