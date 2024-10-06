<!DOCTYPE html>
<html>
<head>
    <title>予約リマインダーメール</title>
</head>
<body>
    <h1>Reseからのお知らせ</h1>
    <h2> {{ $reservation['reserveUser']['name'] }} 様</h2>
    <p>以下の内容で予約を受け付けています。</p>
    <ul>
        <li>店舗名： {{ $reservation['reserveShop']['shop'] }}</li>
        <li>予約日： {{ $reservation['date'] }}</li>
        <li>予約時間： {{ $reservation['time']->format('H:i') }}</li>
        <li>予約人数： {{ $reservation['person'] }}</li>
    </ul>
    <p>ご来店お待ちしております！</p>
    <p>ご来店いただきましたら、下記QRコードを提示してください。</p>
    {!! $qrCode !!}
</body>