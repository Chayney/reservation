# Rese
「Rese」は飲食店予約管理システムです。掲載された店舗の一覧を閲覧することが出来ます。また店舗の予約と気に入った店舗にマークを付けることも出来ます。

## 作成した目的
Laravel学習のまとめとして作成いたしました。提示された要件や成果物のイメージをもとに設計・コーディングを行いました。

## アプリケーションURL
デプロイしていないためURLはありません

## 他のリポジトリ
ありません

## 使用技術
1. PHP 7.4.9
2. Laravel v8.83.8
3. mysql:8.0.26
4. Fortify
5. JavaScript

## 機能一覧
・会員登録機能→名前、メールアドレス、パスワード、確認用パスワードが入力項目となっています。  
・ログイン機能→メールアドレスとパスワードでログイン出来、ログアウト機能もついています。  
・検索機能→エリア検索とジャンル検索が出来ます。またフリーワード検索も可能です。  
・お気に入り機能→店舗ごとに灰色のハートマークが表示されており、お気に入り追加した場合マークが赤色に、お気に入りを削除した場合マークが灰色に戻ります。お気に入りに追加した店舗はマイページで閲覧可能です。  
・店舗ごとに「詳しくみる」ボタンを設置しており選択すると詳細画面に遷移します。  
・予約機能→店舗詳細画面より予約が可能です。予約のキャンセルも出来ます。  

## 機能に関する注意点
・店舗予約とお気に入りの追加及び削除は会員登録したユーザーがログインされている状態で使用できる機能となります。ログインしていない場合はログイン画面に遷移されます。   
・店舗の予約は翌日以降から可能です。当日予約はお電話にてお問い合わせください。  
・お気に入りした店舗はマイページ内に掲載されますが、お気に入りを削除するとマイページから消えるため、再度飲食店一覧ページよりお気に入りの追加を行ってください。  
・フリーワード検索ではエリアとジャンルを検索することは出来ませんので、店名を検索してください。  

## アカウントの種類(テストユーザーが1アカウントあります。)
・ユーザー名: testuser  
・メールアドレス: test@example.com  
・パスワード: password

## テーブル設計
![スクリーンショット_5-10-2024_15932_docs google com](https://github.com/user-attachments/assets/01ec6b9e-fae2-442e-9cd6-e148eca26da2)
![スクリーンショット_5-10-2024_151714_docs google com](https://github.com/user-attachments/assets/d55f6a2f-994e-45c9-9d2f-9cbf1a92ccd2)
![スクリーンショット_5-10-2024_151237_docs google com](https://github.com/user-attachments/assets/260a7134-796d-4184-8147-d8953c6aaa8a)


## ER図


## 環境構築

### コマンドライン上
$docker-compose up -d -build  
$docker-compose exec php bash

### PHPコンテナ内
$composer install

### src上
$cp .env.example .env

### PHPコンテナ内
$php artisan key:generate  
$php artisan migrate  
$php artisan db:seed  
