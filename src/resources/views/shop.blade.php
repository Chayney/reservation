<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>飲食店詳細</title>
  <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
</head>

<body>
  <div class="parent__container">
    <div class="child__container-left">
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

      <div class="left-content">
        @foreach ($shops as $shop)
          <button type="submit" name="shop" value="{{ $shop['shop'] }}">&lt;</button><span> {{ $shop['shop'] }}</span>
          <img src="{{ $shop['shop_image'] }}">
          <span class="area">#{{ $shop['area']['name'] }}</span>
          <span class="genre">#{{ $shop['genre']['name'] }}</span>
          <span class="shop_detail">{{ $shop['shop_detail'] }}</span>
        @endforeach
      </div>
    </div>

    <div class="child__container-right">
      <div class="right-content">
        <h1>予約</h1>
        <form action="/done" method="post">
          @csrf
          <input type="date" id="date" onchange="updateDate()" name="date" value="{{ request()->is('*edit*') ? $reservate->date : '' }}">
          <select id="time" onchange="updateTime()" name="time">
            <option disabled selected>時間を選択してください</option>
            @foreach (['20:00', '20:30', '21:00', '21:30', '22:00'] as $time)
              <option>{{ $time }}</option>
            @endforeach
          </select>
          <select id="person" onchange="updatePerson()" name="person">
            <option disabled selected>人数を選択してください</option>
            @foreach (['1人', '2人', '3人', '4人', '5人以上'] as $person)
              <option>{{ $person }}</option>
            @endforeach
          </select>
        
          
          <div class="reservation__group">
            <table class="reservation__table">
                <tr>
                    <th class="table__header">Shop</th>
                    <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
                    <td class="table__item">{{ $shop['shop'] }}</td>
                </tr>
                <tr>
                    <th class="table__header">Date</th>
                    <td class="table__item" id="selectedDate" name="date">{{ request()->is('*edit*') ? $reserve['date'] : '' }}
                    </td>
                </tr>
                <tr>
                    <th class="table__header">Time</th>
                    <td class="table__item" id="selectedTime" name="time">{{ request()->is('*edit*') ? $reserve['time'] : '' }}
                </tr>
                <tr>
                    <th class="table__header">Number</th>
                    <td class="table__item" id="selectedPerson" name="person">{{ request()->is('*edit*') ? $reserve['person'] : '' }}
                </tr>
            </table>
          </div>
          <input type="submit" value="予約する">
        </form>
        
      </div>
    </div> 
  </div>

  <script>

    function updateDate() {
      var selectedDate = document.getElementById('date').value;
      document.getElementById('selectedDate').innerText = selectedDate;
    }

    function updateTime() {
      var selectedTime = document.getElementById('time').value;
      document.getElementById('selectedTime').innerText = selectedTime;
    }

    function updatePerson() {
      var selectedPerson = document.getElementById('person').value;
      document.getElementById('selectedPerson').innerText = selectedPerson;
    }
    
  </script>
  
</body>
</html>