@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/review_list.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="parent__container">
        <div class="child__container-above">
            @foreach ($shops as $shop)
                <img class="shop_image" src="{{ $shop['shop_image'] }}"><br><br>
                <div class="shop_content">
                    <span class="shop_title">{{ $shop['shop'] }}</span><br><br>
                    <span class="area">#{{ $shop['area']['name'] }}</span>
                    <span class="genre">#{{ $shop['genre']['name'] }}</span><br><br>
                    <span class="shop_detail">{{ $shop['shop_detail'] }}</span>
                </div>
            @endforeach
        </div>       
        <div class="child__container-below">
            <h2 class="title_text">お客様のレビュー</h2>
            @foreach ($lists as $list)
                <div class="review_content">
                    <div class="review-user">
                        <span>{{ $list['reviewUser']['name'] }}さん</span>
                        <span>{{ $list['updated_at'] }}</span>
                    </div>
                    <span class="star-rating" data-rate="{{ $list['rating'] }}"></span>
                    <span class="comment">{{ $list['comment'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
@endsection