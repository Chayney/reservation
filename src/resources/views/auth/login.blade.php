@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login__content">
  <div class="login-form__heading">
  <span class="heading-name">Login</span>
  </div>
  <form class="form" action="/login" method="post">
    @csrf
    <div class="form__group">
      <img class="label_image" src="{{ asset('image/mail.png') }}">
      <div class="form__group-content">
        <div class="form__input--text">
          <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" />
        </div>
        <div class="form__error">
          @error('email')
          {{ $message }}
          @enderror
        </div>
      </div>
    </div>
    <div class="form__group">
      <img class="label_image" src="{{ asset('image/key.png') }}">
      <div class="form__group-content">
        <div class="form__input--text">
          <input type="password" name="password" placeholder="Password" />
        </div>
        <div class="form__error">
          @error('password')
          {{ $message }}
          @enderror
        </div>
      </div>
    </div>
    <button class="form__button-submit" type="submit">ログイン</button>
  </form>
</div>
@endsection