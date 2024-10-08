<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>飲食店一覧</title>
  <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="nav-humberger">
      <input id="drawer_input" class="drawer_hidden" type="checkbox">
      <label for="drawer_input" class="drawer_open"><span></span></label>
    <nav class="nav_content">
        <ul class="nav_list">
          <li class="nav_item"><a href="/">Home</a></li>
          @if (Request::is('register'))
            <li class="nav_item"><a href="{{ url('login') }}">Login</a></li>
            <li class="nav_item"><a href="{{ url('mypage') }}">Mypage</a></li>
          @else
            <li class="nav_item"><a href="{{ url('register') }}">Registration</a></li>
            <li class="nav_item"><a href="{{ url('mypage') }}">Mypage</a></li>
          @endif
        </ul>
    </nav>
    </div>
    <a class="header__logo" href="/">
      Rese
    </a>
  </header>
  <main>
    @yield('content')
  </main>
</body>

</html>