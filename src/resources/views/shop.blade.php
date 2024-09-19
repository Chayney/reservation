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
          </div>
          <a class="header__logo" href="/">
            Rese
          </a>
        </div>
      </header>

      <div class="left-content">
        @foreach ($shops as $shop)
          <a class="home" href="{{ url('/') }}">&lt;</a><span class="shop_name"> {{ $shop['shop'] }}</span>
          <img src="{{ $shop['shop_image'] }}"><br><br>
          <span class="area">#{{ $shop['area']['name'] }}</span>
          <span class="genre">#{{ $shop['genre']['name'] }}</span><br><br>
          <span class="shop_detail">{{ $shop['shop_detail'] }}</span>
        @endforeach
      </div>
    </div>

    <div class="child__container-right">
      <div class="right-content">
        <h1>予約</h1>
        <form action="/done" method="post">
          @csrf
          <input type="date" class="select_form_date" id="date" onchange="updateDate()" name="date" value="{{ old('date', request()->is('*edit*') ? $reserve['date'] : '') }}">
          <div class="error__item">
            @error('date')
              <span class="error__message">{{ $message }}</span>
            @enderror
          </div>
          <label class="select_form_time">
          <select id="time" class="select_form" onchange="updateTime()" name="time">
            <option disabled selected>時間を選択してください</option>
            @foreach (['20:00', '20:30', '21:00', '21:30', '22:00'] as $time)
              <option value="{{ $time }}" {{ old('time') == $time ? 'selected' : '' }}>{{ $time }}</option>
            @endforeach
          </select>
          </label>
          <div class="error__item">
            @error('time')
              <span class="error__message">{{ $message }}</span>
            @enderror
          </div>
          <label class="select_form_person">
          <select id="person" class="select_form" onchange="updatePerson()" name="person">
            <option disabled selected>人数を選択してください</option>
            @foreach (['1人', '2人', '3人', '4人', '5人以上'] as $person)
              <option value="{{ $person }}" {{ old('person') == $person ? 'selected' : '' }}>{{ $person }}</option>
            @endforeach
          </select>
          </label>
          <div class="error__item">
            @error('person')
              <span class="error__message">{{ $message }}</span>
            @enderror
          </div> 
          
          <div class="reservation__group">
            <table class="reservation__table">
              <tr>
                <th class="table__header">Shop</th>
                <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
                <td class="table__item">{{ $shop['shop'] }}</td>
              </tr>
              <tr>
                <th class="table__header">Date</th>
                <td class="table__item" id="selectedDate" name="date">{{ old('date', request()->is('*edit*') ? $reserve['date'] : '') }}
                </td>
              </tr>
              <tr>
                <th class="table__header">Time</th>
                <td class="table__item" id="selectedTime" name="time">{{ old('time', request()->is('*edit*') ? $reserve['time'] : '') }}
              </tr>
              <tr>
                <th class="table__header">Number</th>
                <td class="table__item" id="selectedPerson" name="person">{{ old('person', request()->is('*edit*') ? $reserve['person'] : '') }}
              </tr>
            </table>
          </div>
          <input type="submit" class="reserve_button" value="予約する">
        </form>
      </div>
    </div> 
  </div>

  <script src="{{ asset('js/shop.js') }}"></script>

</body>

</html>