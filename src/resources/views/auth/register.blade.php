@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register__content">
  <div class="register-form__heading">
    <span class="heading-name">Registration</span>
  </div>
  <form class="form" action="/register" method="post">
    @csrf
    <div class="form__group">
      <img class="label_image" src="{{ asset('image/person.png') }}">
      <div class="form__group-content">
        <div class="form__input--text">
          <input type="text" name="name" value="{{ old('name') }}" placeholder="Username" />
        </div>
        <div class="form__error">
          @error('name')
          {{ $message }}
          @enderror
        </div>
      </div>
    </div>
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
    <button class="form__button-submit" type="submit">登録</button>
  </form>
</div>
@endsection