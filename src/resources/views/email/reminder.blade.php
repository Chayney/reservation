<!DOCTYPE html>
<html>
<head>
    <title>予約リマインダーメール</title>
</head>
<body>
    <h1>Reseからのお知らせ</h1>
    <h2> {{ $reservation->reserveUser->name }} 様</h2>
    <p>以下の内容で予約を受け付けています。</p>
    <ul>
        <li>店舗名： {{ $reservation->reserveShop->shop }}</li>
        <li>予約日： {{ \Carbon\Carbon::parse($reservation->date)->locale('ja')->isoFormat('YYYY-MM-DD (dd)') }}</li>
        <li>予約時間： {{ date('H:i',strtotime($reservation->time)) }}</li>
        <li>予約人数： {{ $reservation->person }}</li>
    </ul>
    <p>ご来店お待ちしております！</p>
</body>