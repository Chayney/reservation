@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/review.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="parent__container">
        <div class="child__container-left">
            <div class="left_content">
                <div class="shop_content">
                @foreach ($shops as $shop)
                    <img class="shop_image" src="{{ $shop['shop_image'] }}"><br><br>
                    <span class="shop_title">{{ $shop['shop'] }}</span><br><br>
                    <span class="area">#{{ $shop['area']['name'] }}</span>
                    <span class="genre">#{{ $shop['genre']['name'] }}</span><br><br>
                    <span class="shop_detail">{{ $shop['shop_detail'] }}</span>
                @endforeach
                </div>
            </div>
        </div>
       
        <div class="child__container-right">
            <h2 class="title_text">お客様のレビュー</h2>
            <?php dd($lists) ?>
            @foreach ($lists as $list)
    @endforeach
        </div>
    </div>
@endsection