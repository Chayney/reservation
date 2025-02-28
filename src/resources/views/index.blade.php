<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>飲食店一覧</title>
  <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>

<body>
  <header class="header">
    <div class="nav-humberger">
      <input id="drawer_input" class="drawer_hidden" type="checkbox">
      <label for="drawer_input" class="drawer_open"><span></span></label>
    <nav class="nav_content">
        <ul class="nav_list">
            <li class="nav_item"><a href="/">Home</a></li>
            @if (Auth::check() && Auth::user()->hasVerifiedEmail())
              <li class="nav_item">
                <form action="/logout" method="post">
                  @csrf
                  <button class="logout">Logout</button>
                </form>
              </li>
              <li class="nav_item"><a href="{{ url('mypage') }}">Mypage</a></li>
            @else
              <li class="nav_item"><a href="{{ url('register') }}">Registration</a></li>
              <li class="nav_item"><a href="{{ url('login') }}">Login</a></li>
            @endif
        </ul>
    </nav>
    <a class="header__logo" href="/">
      Rese
    </a>
    </div>
    <div class="search-humberger">
      <input id="drawer-input" class="drawer-hidden" type="checkbox">
      <label for="drawer-input" class="drawer-open"><img class="search-icon" src="{{ asset('image/magnifying_glass.png') }}"></label>
      <div class="search-slide">
          <form class="search-sort-mobile" action="/search" method="get">
              <label class="sort-label-mobile">並べ替え:</label>
              <li class="nav-item-sort-mobile">
                  <select class="select_form_sort-mobile" onchange="submit(this.form)" name="sort">
                      <option value="random" {{ request('sort') == 'random' ? 'selected' : '' }}>ランダム</option>
                      <option value="high_rating" {{ request('sort') == 'high_rating' ? 'selected' : '' }}>評価が高い順</option>
                      <option value="low_rating" {{ request('sort') == 'low_rating' ? 'selected' : '' }}>評価が低い順</option>
                  </select>
              </li>
          </form>
          <form class="search-list-mobile" action="/search" method="get">
              <li class="nav-item-mobile">
                  <label class="select_box-mobile">
                      <select class="select_form-mobile" onchange="submit(this.form)" name="area">
                          <option value="">All area</option>
                          @foreach ($areas as $area)
                              <option value="{{ $area['id'] }}" {{ request('area') == $area->id ? 'selected' : '' }}>{{ $area['name'] }}</option>
                          @endforeach
                      </select>
                  </label>
              </li>
              <li class="nav-item-mobile">
                  <label class="select_box-mobile">
                      <select class="select_form-mobile" onchange="submit(this.form)" name="genre">
                          <option value="">All genre</option>
                          @foreach ($genres as $genre)
                              <option value="{{ $genre['id'] }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>{{ $genre['name'] }}</option>
                          @endforeach
                      </select>
                  </label>
              </li>
          </form>
          <form class="search-word-mobile" action="/search" method="get">
              <li class="nav-item-mobile">
                  <span class="search_box-mobile"></span>
                  <input type="text" name="keyword" placeholder="Search ..." value="{{ request('keyword') }}">
              </li>
          </form>
      </div>
    </div>
    <ul class="nav-list">
      <form class="search-sort" action="/search" method="get">
        <label class="sort-label">並べ替え:</label>
        <li class="nav-item-sort">
          <select class="select_form_sort" onchange="submit(this.form)" name="sort">
            <option value="random" {{ request('sort') == 'random' ? 'selected' : '' }}>ランダム</option>
            <option value="high_rating" {{ request('sort') == 'high_rating' ? 'selected' : '' }}>評価が高い順</option>
            <option value="low_rating" {{ request('sort') == 'low_rating' ? 'selected' : '' }}>評価が低い順</option>
          </select>
          <label></label>
        </li>
      </form>
      <form class="search-list" action="/search" method="get">
        <li class="nav-item">
          <label class="select_box">
          <select class="select_form" onchange="submit(this.form)" name="area">
            <option value="">All area</option>
            @foreach ($areas as $area)
              <option value="{{ $area['id'] }}" {{ request('area') == $area->id ? 'selected' : '' }}>{{ $area['name'] }}</option>
            @endforeach
          </select>
          </label>
        </li>
        <li class="nav-item">
          <label class="select_box">
          <select class="select_form" onchange="submit(this.form)" name="genre">
            <option value="">All genre</option>
            @foreach ($genres as $genre)
              <option value="{{ $genre['id'] }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>{{ $genre['name'] }}</option>
            @endforeach
          </select>
          </label>
        </li>
      </form>
      <form class="search-word" action="/search" method="get">
        <li class="nav-item">
          <span class="search_box"><img src="{{ asset('image/magnifying_glass.png') }}"></span>
          <input type="text" name="keyword" placeholder="Search ..." value="{{  request('keyword') }}">
        </li>
      </form>
    </ul>
  </header>
  <main>
    <div class="parent__container">
      @foreach ($shops as $shop)
        <div class="child__container">
          <img class="shop_image" src="{{ $shop['shop_image'] }}">
          <div class="shop">
            <span class="shop_name">{{ $shop['shop'] }}</span>
            <img class="star" src="{{ asset('image/yellow_star.jpg') }}">
            <span class="score">{{ $shop['avg_rating'] == 0 ? '投稿無し' : $shop['avg_rating'] }}</span>
          </div>
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
  <main>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const navInput = document.getElementById('drawer_input');
      const searchInput = document.getElementById('drawer-input');
      const drawerOpen = document.getElementsByClassName('drawer_open')[0];
      const searchOpen = document.getElementsByClassName('drawer-open')[0];
      navInput.addEventListener('change', function() {
          if (navInput.checked) {
            drawerOpen.style.zIndex = 100;
            searchOpen.style.zIndex = 0;
            searchInput.checked = false;
            searchOpen.style.zIndex = 0;
          }
      });
      searchInput.addEventListener('change', function() {
          if (searchInput.checked) { 
            searchOpen.style.zIndex = 100;
            drawerOpen.style.zIndex = 0;
            navInput.checked = false;
          }
      });
    });
  </script>
</body>

</html>