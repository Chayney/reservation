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
    <div class="header__inner">
        <div class="nav-humberger">
    
            <!-- ハンバーガーメニューの表示・非表示を切り替えるチェックボックス -->
            <input id="drawer_input" class="drawer_hidden" type="checkbox">

            <!-- ハンバーガーアイコン -->
            <label for="drawer_input" class="drawer_open"><span></span></label>

        <!-- メニュー -->
        <nav class="nav_content">
            <ul class="nav_list">
                <li class="nav_item"><a href="">Home</a></li>
                <li class="nav_item"><a href="">Registration</a></li>
                <li class="nav_item"><a href="">Login</a></li>
            </ul>
        </nav>
        </div>
      <a class="header__logo" href="#">
        Rese
      </a>
    </div>
  </header>

  <main>
    @yield('content')
  </main>

</body>

</html>