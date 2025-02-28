@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/admin_review.css') }}">
@endsection

@section('content')
  <!-- PC版レイアウト -->
  <div class="admin">
    <div class="admin__inner">  
      <table class="admin__table">
        <tr class="admin__row">
          <th class="admin__label_id">番号</th>
          <th class="admin__label_name">ユーザー名</th>
          <th class="admin__label_comment">口コミ</th>
          <th class="admin__label_delete">削除</th>
        </tr>
        @foreach ($reviews as $review)   
          <tr class="admin__row">
            <td class="admin__label_id">{{ $review['id'] }}</td>
            <td class="admin__label_name">{{ $review['reviewUser']['name'] }}</td>
            <td class="admin__label_comment">{{ $review['comment'] }}</td>
            <td class="admin__label_delete">
              <form action="/admin/review/destroy" class="trash-group" method="post">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" value="{{ $review['id'] }}">
                <button class="trash" type="submit" onclick="return showAlert('本当に口コミを削除しますか？')">
                  <img class="trash_image" src="{{ asset('image/trash.jpg') }}">
                </button>
              </form>
            </td>
          </tr>
        @endforeach
      </table>
    </div>

    <!-- スマホ版レイアウト -->
    <div class="parent__card">
      @foreach ($reviews as $review)
        <div class="card">
          <table class="user__table">
            <tr>
              <th class="table__header">番号</th>
              <td class="table__item">{{ $review['id'] }}</td>
              <td class="table__item_delete">
                <form action="/admin/review/destroy" class="trash-group" method="post">
                  @csrf
                  @method('DELETE')
                  <input type="hidden" name="id" value="{{ $review['id'] }}">
                  <button class="trash" type="submit" onclick="return showAlert('本当に口コミを削除しますか？')">
                    <img class="trash_image" src="{{ asset('image/trash.jpg') }}">
                  </button>
                </form>
              </td>
            </tr>
            <tr>
              <th class="table__header">ユーザー名</th>
              <td class="table__item">{{ $review['reviewUser']['name'] }}</td>
            </tr>
            <tr>
              <th class="table__header">口コミ</th>
              <td class="table__item">{{ $review['comment'] }}</td>
            </tr>
          </table>
        </div>
      @endforeach
    </div>
    {{ $reviews->appends(request()->query())->links('pagination::custom') }}
  </div>
  <script>
    function showAlert(message) {
      return confirm(message);
    }
    function removeEmptyFields(form) {
      Array.from(form.elements).forEach(input => {
        if (!input.value) {
          input.name = '';
        }
      });
      return true;
    }
  </script>
@endsection