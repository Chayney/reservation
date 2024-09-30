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
            <h2 class="title_text">今回のご利用はいかがでしたか？</h2>
            <form action="/review/store" method="post">
                @csrf
                <div class="form-rating">
                    <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
                    <input class="form-rating__input" id="star5" name="rating" type="radio" value="5">
                    <label class="form-rating__label" for="star5"><i class="fa-solid fa-star"></i></label>

                    <input class="form-rating__input" id="star4" name="rating" type="radio" value="4">
                    <label class="form-rating__label" for="star4"><i class="fa-solid fa-star"></i></label>

                    <input class="form-rating__input" id="star3" name="rating" type="radio" value="3">
                    <label class="form-rating__label" for="star3"><i class="fa-solid fa-star"></i></label>

                    <input class="form-rating__input" id="star2" name="rating" type="radio" value="2">
                    <label class="form-rating__label" for="star2"><i class="fa-solid fa-star"></i></label>

                    <input class="form-rating__input" id="star1" name="rating" type="radio" value="1">
                    <label class="form-rating__label" for="star1"><i class="fa-solid fa-star"></i></label>
                    <label class="rating">評価:</label>
                </div>
                <div class="error__item">
                @error ('rating')
                    <span class="error__message">{{ $message }}</span>
                @enderror
                </div>
                <div class="comment_group">
                    <label class="comment">コメント:</label>
                    <textarea id="textarea" class="comment_box" name="comment" rows="5"></textarea>   
                </div>
                <div class="text_count">
                    <p>文字数: <span id="charCount">0</span>/300</p>
                </div>
                <div class="error__item">
                @error('comment')
                    <span class="error__message">{{ $message }}</span>
                @enderror
                </div>
                <button class="review_post" type="submit">レビューを投稿</button>
            </form>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const textarea = document.getElementById('textarea');
        const charCount = document.getElementById('charCount');
        const maxLength = 300;

        textarea.addEventListener('input', function () {
            const currentLength = textarea.value.length;
            charCount.textContent = currentLength;

            if (currentLength > maxLength) {
                charCount.classList.add('over-limit');
            } else {
                charCount.classList.remove('over-limit');
            }
        });
    });
</script>