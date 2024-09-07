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
    <div class="header__inner">
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
              <li class="nav_item"><a href="{{ url('auth.register') }}">Registration</a></li>
              <li class="nav_item"><a href="{{ url('auth.login') }}">Login</a></li>
              @endif
          </ul>
      </nav>
      </div>
      <a class="header__logo" href="/">
        Rese
      </a>
    </div>
  </header>

  <main>
    <div class="contact-form__content">
      <div class="parent__container-left">
        <h2 class="left-title">予約状況</h2>
        <div class="child__container-left">
          <form action="/mypage/destroy" method="post">
            @csrf
            @method('DELETE')
          @foreach ($reservates as $reservate)
          <table class="reservation__table">
            <tr>
              <th class="table__header"><img class="clock_image" src="{{ asset('image/clock.png') }}"></th>
              <td class="table__item">予約{{ $loop->iteration }}</td>
              <td class="table__item">
                <button class="reserve_delete" type="submit"><img class="batsu_image" src="{{ asset('image/batsu.png') }}"></button>
              </td>
            </tr>
            <tr>
              <th class="table__header">Shop</th>
              <td class="table__item">{{ $reservate['reserve_shop']['shop'] }}</td>
            </tr>
            <tr>
              <th class="table__header">Date</th>
              <td class="table__item">{{ $reservate['date'] }}</td>
            </tr>
            <tr>
              <th class="table__header">Time</th>
              <td class="table__item">{{ $reservate['bookTime']->format('H:i') }}</td>
            </tr>
            <tr>
              <th class="table__header">Number</th>
              <td class="table__item">{{ $reservate['person'] }}</td>
            </tr>
          </table>
          @endforeach
          </form>
        </div>
      </div>
      <div class="parent__container-right">
        <div class="text_group">
        @if (Auth::check())
          <h2>{{ Auth::user()['name'] }}さん</h2>
        @endif
          <h3>お気に入り店舗</h3>
        </div>
          @foreach ($favoriteShops as $favoriteShop)
          <div class="child__container-right">
            <img class="shop_image" src="{{ $favoriteShop['shop_image'] }}">
            <span class="shop">{{ $favoriteShop['shop'] }}</span>
            <span class="area">#{{ $favoriteShop['area'] }}</span>
            <span class="genre">#{{ $favoriteShop['genre'] }}</span>
            <form action="/detail/{{ $favoriteShop['id'] }}" method="get">
              <button class="detail" type="submit" name="shop" value="{{ $favoriteShop['shop'] }}">詳しくみる</button>
            </form>
            <form action="/favoriteshop/destroy" method="post">
              @csrf
              @method('DELETE')
            <input type="hidden" name="shop_id" value="{{ $favoriteShop['id'] }}">
            <button class="favorite" type="submit">
              <img src="{{ asset('image/heart_red.png') }}">
            </button>
            </form>
          </div>
          @endforeach    
      </div>
    </div>
  <main>
</body>
</html>