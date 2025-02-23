@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/review.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="parent__container">
        <div class="child__container-left">
            <h1 class="page-title">今回のご利用はいかがでしたか？</h1>      
            @foreach ($shops as $shop)
                <div class="child__container">
                    <img class="shop_image" src="{{ $shop['shop_image'] }}">
                    <span class="shop">{{ $shop['shop'] }}</span>
                    <span class="area">#{{ $shop['area']['name'] }}</span>
                    <span class="genre">#{{ $shop['genre']['name'] }}</span>
                    <form action="/detail/{{ $shop['id'] }}" method="get">
                        <button class="detail" type="submit" name="shop" value="{{ $shop['shop'] }}">詳しくみる</button>
                    </form>
                    @if (Auth::check() && Auth::user()->hasVerifiedEmail())
                        @if ($shop->favoriteMarked())
                            <form action="/favorite/destroy{shop}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
                                <button class="favorite" type="submit">
                                    <img src="{{ asset('image/red_heart.png') }}">
                                </button>
                            </form>
                        @else
                            <form action="/favorite/store" method="post">
                                @csrf
                                <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
                                <button class="favorite" type="submit">
                                <img src="{{ asset('image/gray_heart.png') }}">
                                </button>
                            </form>
                        @endif
                    @else
                        <button class="favorite" onclick="location.href='/login'">
                            <img src="{{ asset('image/gray_heart.png') }}">
                        </button>
                    @endif
                </div>
            @endforeach      
        </div>     
        <div class="child__container-right">
        @if (session('alert'))
            <script>
                alert('{{ session('alert') }}');
            </script>
        @endif
            <h2 class="title_text">体験を評価してください</h2>
            @forelse ($lists as $list)
                <form action="/review/update" class="store-review" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-rating">
                        <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
                        <input class="form-rating__input" id="star5" name="rating" type="radio" value="5" {{ $list['rating'] == 5 ? 'checked' : '' }}>
                        <label class="form-rating__label" for="star5"><i class="fa-solid fa-star"></i></label>

                        <input class="form-rating__input" id="star4" name="rating" type="radio" value="4" {{ $list['rating'] == 4 ? 'checked' : '' }}>
                        <label class="form-rating__label" for="star4"><i class="fa-solid fa-star"></i></label>

                        <input class="form-rating__input" id="star3" name="rating" type="radio" value="3" {{ $list['rating'] == 3 ? 'checked' : '' }}>
                        <label class="form-rating__label" for="star3"><i class="fa-solid fa-star"></i></label>

                        <input class="form-rating__input" id="star2" name="rating" type="radio" value="2" {{ $list['rating'] == 2 ? 'checked' : '' }}>
                        <label class="form-rating__label" for="star2"><i class="fa-solid fa-star"></i></label>

                        <input class="form-rating__input" id="star1" name="rating" type="radio" value="1" {{ $list['rating'] == 1 ? 'checked' : '' }}>
                        <label class="form-rating__label" for="star1"><i class="fa-solid fa-star"></i></label>
                        <label class="rating">評価:</label>
                    </div>
                    <div class="error__item">
                        @error ('rating')
                            <span class="error__message">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="comment_group">
                        <label class="comment">口コミを投稿</label>
                        <textarea id="textarea" class="comment_box" name="comment" rows="5" placeholder='カジュアルな夜のお出かけにおすすめのスポット'>{{ $list['comment'] }}</textarea>   
                    </div>
                    <div class="text_count">
                        <p><span id="charCount">0</span>/400 (最高文字数) </p>
                    </div>
                    <div class="error__item">
                        @error('comment')
                            <span class="error__message">{{ $message }}</span>
                        @enderror
                    </div>          
                    <label class="image-label">画像の追加</label>
                    <div class="form__input--image">
                        <label id="uploadButton" class="item_image"><input type="file" id="upload" onchange="previewImage(event)" class="file" name="image_url"><img class="edit" src="{{ $list['image_url'] ? asset('/storage/' . $list['image_url']) : '' }}"></label>
                        <img id="uploadedImage" src="">
                    </div>
                    <div class="error__item">
                        @error ('image_url')
                            <span class="error__message">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="review-button">
                        <button class="review_post" name="id" value="{{ $list['id'] }}" type="submit">口コミを投稿</button>
                    </div>
                </form>
            @empty
                <form action="/review/store" class="store-review" method="post" enctype="multipart/form-data">
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
                        <label class="comment">口コミを投稿</label>
                        <textarea id="textarea" class="comment_box" name="comment" rows="5" placeholder='カジュアルな夜のお出かけにおすすめのスポット'></textarea>   
                    </div>
                    <div class="text_count">
                        <p><span id="charCount">0</span>/400 (最高文字数) </p>
                    </div>
                    <div class="error__item">
                        @error('comment')
                            <span class="error__message">{{ $message }}</span>
                        @enderror
                    </div>          
                    <label class="image-label">画像の追加</label>
                    <div class="form__input--image">
                        <label id="uploadButton" class="edit">クリックして画像を追加<br>またはドラッグアンドドロップ<input type="file" id="upload" onchange="previewImage(event)" class="file" name="image_url"></label>
                        <img id="uploadedImage" src="">
                    </div>
                    <div class="error__item">
                        @error ('image_url')
                            <span class="error__message">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="review-button">
                        <button class="review_post" type="submit">口コミを投稿</button>
                    </div>
                </form>
            @endforelse
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const textarea = document.getElementById('textarea');
        const charCount = document.getElementById('charCount');
        const maxLength = 400;

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
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('uploadedImage');
            output.src = reader.result;
            output.style.width = 'initial';
            output.style.height = '100px';
            document.getElementById('uploadButton').style.display = 'none';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
    window.onload = function() {
        var imageElements = document.getElementsByClassName('edit');
        var assetPath = "{{ asset( '/storage/' ) }}";
        @foreach ($lists as $list)
            (function(list) {
                if (imageElements.length > 0) {
                    var imageSrc = imageElements[0].src;
                    if (imageSrc && imageSrc !== assetPath + list['image_url']) {
                        document.getElementById('uploadButton').style.display = 'none';
                    }
                }
            })({{ json_encode($list) }});
        @endforeach
    }
</script>