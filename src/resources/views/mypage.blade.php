<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>マイページ</title>
  <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
</head>

<body>
  <header class="header">
    <div class="nav-humberger">
      <input id="drawer_input" class="drawer_hidden" type="checkbox">
      <label for="drawer_input" class="drawer_open"><span></span></label>
    <nav class="nav_content">
      <ul class="nav_list">
        <li class="nav_item"><a href="{{ url('/') }}">Home</a></li>
        @if (Auth::check())
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
  </header>

  <main>
    <div class="container">
      <div class="tabs">
        <button class="tab-button" data-target="tab1">予約状況</button>
        <button class="tab-button" data-target="tab2">お気に入り店舗</button>
      </div>
      @if (Auth::check())
        <h1 class="login_user">{{ Auth::user()['name'] }}さん</h1>
      @endif
      <div class="tab-content">
        <div id="tab1" class="tab-pane">
        <h2 class="left-title">予約状況</h2>
        <div class="child__container-left">
          @foreach ($reservates as $reservate)
          <table class="reservation__table">
            <tr>
              <th class="table__header_clock"><img class="clock_image" src="{{ asset('image/clock.png') }}"></th>
              <td class="table__item">予約{{ $loop->iteration }}</td>
              <form action="/mypage/edit" method="get">
              <td class="table__item">
                <button class="reserve_modify" type="submit" name="id" value="{{ $reservate['id'] }}"><img class="edit_image" src="{{ asset('image/edit.png') }}"></button>
              </td>
              </form>
              <form action="/mypage/destroy" method="post">
                @csrf
                @method('DELETE')
              <td class="table__item">
                <input type="hidden" name="id" value="{{ $reservate['shop_id'] }}">
                <button class="reserve_delete" type="submit" onclick="return showAlert('本当に予約を削除しますか？')"><img class="batsu_image" src="{{ asset('image/batsu.png') }}"></button>
              </td>
              </form>
            </tr>
            <tr>
              <th class="table__header">Shop</th>
              <td class="table__item">{{ $reservate['reserveShop']['shop'] }}</td>
            </tr>
            <tr>
              <th class="table__header">Date</th>
              <td class="table__item">{{ $reservate['date'] }}</td>
            </tr>
            <tr>
              <th class="table__header">Time</th>
              <td class="table__item">{{ $reservate['time']->format('H:i') }}</td>
            </tr>
            <tr>
              <th class="table__header">Number</th>
              <td class="table__item">{{ $reservate['person'] }}</td>
            </tr>
          </table>
          @endforeach
        </div>
        </div>
        <div id="tab2" class="tab-pane">
          <div class="text_group">
            <h2 class="right-title">お気に入り店舗</h2>
          </div>
          <div class="parent__container-right">
            @foreach ($favoriteShops as $favoriteShop)
            <div class="child__container-right">
              <img class="shop_image" src="{{ $favoriteShop['shop_image'] }}">
              <span class="shop">{{ $favoriteShop['shop'] }}</span>
              <span class="area">#{{ $favoriteShop['area']['name'] }}</span>
              <span class="genre">#{{ $favoriteShop['genre']['name'] }}</span>
              <form action="/detail/{{ $favoriteShop['id'] }}" method="get">
                <button class="detail" type="submit" name="shop" value="{{ $favoriteShop['shop'] }}">詳しくみる</button>
              </form>
              <form action="/favoriteshop/destroy" method="post">
                @csrf
                @method('DELETE')
              <input type="hidden" name="shop_id" value="{{ $favoriteShop['id'] }}">
              <button class="favorite" type="submit" onclick="return showAlert('本当にお気に入りから削除しますか？')">
                <img src="{{ asset('image/red_heart.png') }}">
              </button>
              </form>
            </div>
            @endforeach
          </div>  
        </div>
      </div>
    </div>    
  <main>

  <script src="{{ asset('js/mypage.js') }}" type="text/javascript"></script>

</body>

</html>