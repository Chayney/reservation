@extends('layouts.review')

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
        <h2 class="title_text">お客様のレビュー</h2>    
        <div class="child__container-below">
            @foreach ($lists as $list)
                <div class="review_content">
                    @if (Auth::check() && (Auth::user()->hasVerifiedEmail() || Auth::user()->name === 'testuser') && Auth::user()->id === $list['reviewUser']['id'])
                        <div class="review-user">
                            <span>{{ $list['reviewUser']['name'] }}さん</span>
                            <span>{{ $list['updated_at']->format('Y-m-d') }}</span>
                            <a href="/review/{{ $list['id'] }}?id={{ $list['id'] }}&shop_id={{ $shop['id'] }}&shop={{ $shop['shop'] }}" class="review_edit">口コミを編集する</a>
                            <form action="/review/destroy" method="post" class="review-destroy">
                                @csrf
                                @method('DELETE')                         
                                <input type="hidden" name="id" value="{{ $list['id'] }}">
                                <button class="review_delete" type="submit" onclick="return showAlert('本当にお気に入りを削除しますか？')">口コミを削除する</button>
                            </form>
                        </div>
                    @else
                        <div class="review-user">
                            <span>{{ $list['reviewUser']['name'] }}さん</span>
                            <span>{{ $list['updated_at']->format('Y-m-d') }}</span>
                        </div>
                    @endif
                    <span class="star-rating" data-rate="{{ $list['rating'] }}"></span>
                    <span class="comment">{{ $list['comment'] }}</span>
                    <img class="image" src="{{ asset( '/storage/' . $list['image_url']) }}" alt="">
                </div>
            @endforeach
        </div>
    </div>
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            const reviewContents = document.querySelectorAll('.review_content');
            const adjustHeight = (content) => {
                const comment = content.querySelector('.comment');
                const image = content.querySelector('.image');               
                const commentHeight = comment ? comment.scrollHeight : 0;
                const imageHeight = image ? image.scrollHeight : 0;
                content.style.minHeight = `${Math.max(commentHeight, imageHeight) + 40}px`;
            };
            reviewContents.forEach(content => {
                adjustHeight(content);
                new MutationObserver(() => adjustHeight(content)).observe(content, { childList: true, subtree: true, characterData: true });
            });
        });
        function showAlert(message) {
            return confirm(message);
        }
    </script>
@endsection