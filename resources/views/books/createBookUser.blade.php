@extends('layouts.footer')
@extends('layouts.header')
@section('content')
<h1>Выдать книгу пользователю</h1>
<p><a href="{{route('showUser', $userId)}}" class="navigation">Вернуться</a>
<div class="booksTable">
    {{$books->links()}}
    <div class="search">
        <form method="post">
            <input type="text" name="search" class="form-control">
            <input type="submit" value="Поиск" class="btn btn-primary">
            {{ csrf_field() }}
        </form>
    </div>
    <table cellspacing="0" border="1" cellpadding="10" class="adminTable">
        <tr>
            <td>Выдать</td>
            <td title="Обложка">Обл.</td>
            <td>Название</a></td>
            <td>Автор</td>
            <td>Описание</td>
            <td>Издательство</td>
            <td title="Количество страниц">Стр.</td>
            <td title="Количество\Взято книг">К\В</td>
            <td>Инвентарный номер</td>
        </tr>
        @foreach($books as $book)
            <tr>
                <td><a id="{{$book->id}}" class="show" title="Выдать книгу" style="cursor:pointer">Выдать</td>
                <td><a href="{{route('showBook', $book->id)}}" title="Перейти на книгу"><img src="../../../{{$book->image}}" style="width: 40px"></a></td>
                <td title="{{$book->title_book}}"><a href="{{route('showBook', $book->id)}}">{{str_limit($book->title_book, 25)}}</a></td>
                <td title="{{$book->author}}">{{str_limit($book->author, 15)}}</td>
                <td title="{{$book->description}}">{{str_limit($book->description, 15)}}</td>
                <td title="{{$book->publisher}}">{{str_limit($book->publisher, 25)}}</td>
                <td>{{$book->pages_count}}</td>
                <td>{{$book->in_all}}</td>
                <td>{{$book->inventory_number}}</td>
            </tr>
        @endforeach
    </table>
</div>

<div class='dateForm' align="center">
    <form method="post" action="{{route('storeBookUser')}}">
        {{ csrf_field() }}
        <p><input type="hidden" class="id" value="" name="book_id"></p>
        <p><input type="hidden" value="{{$userId}}" name="user_id"></p>
        <p>Задайте дату до которой необходимо вернуть книгу</p>
        <p><input type="date" name="return_date" value="{{date('Y-m-d',strtotime("+14 day"))}}"></p>
        <p><input type="button" class="subm no btn btn-primary" value="Отмена"><input type="submit" class="btn btn-primary"  value="Выдать"></p>
    </form>
</div>

<script>
    $(document).ready(function(){
        $('.no').click(function(){
            $('.dateForm').fadeOut('slow');
        });
        $('.show').click(function(e){
            $('input.id').val($(this).attr('id'));
            $('.dateForm').fadeIn('slow');
            $('.dateForm').css({
                'top':e.pageY,
                'left':e.pageX
            });
        });
    });
</script>
@endsection


