@extends('layouts.footer')
@extends('layouts.header')
@section('content')
<h1>Работа с книгами</h1>
<p><a href="{{route('admin')}}" class="navigation">Вернуться</a></p>
<p><a href="{{route('createBook')}}" class="navigation">Добавить книгу</a></p>
<p></p>
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
            <td><a href="{{route('booksAdmin', ['id', $order])}}">ID</a></td>
            <td title="Обложка">Обл.</td>
            <td><a href="{{route('booksAdmin', ['title_book', $order])}}">Название</a></td>
            <td><a href="{{route('booksAdmin', ['author', $order])}}">Автор</a></td>
            <td>Описание</td>
            <td><a href="{{route('booksAdmin', ['publisher', $order])}}">Издательство</a></td>
            <td title="Количество страниц"><a href="{{route('booksAdmin', ['pages_count', $order])}}">Стр.</a></td>
            <td title="Количество\Взято книг"><a href="{{route('booksAdmin', ['in_all', $order])}}">К\В</a></td>
            <td>Жанры</td>
            <td>Инвентарный номер</td>
        </tr>
        @foreach($books as $book)
            <tr>
                <td>{{$book->id}}</td>
                <td><a href="{{route('showBook', $book->id)}}" title="Перейти на книгу"><img src="{{URL::to('../')}}/{{$book->image}}" style="width: 40px"></a></td>
                <td title="{{$book->title_book}}"><a href="{{route('showBook', $book->id)}}">{{str_limit($book->title_book, 25)}}</a></td>
                <td title="{{$book->author}}">{{str_limit($book->author, 15)}}</td>
                <td title="{{$book->description}}">{{str_limit($book->description, 15)}}</td>
                <td title="{{$book->publisher}}">{{str_limit($book->publisher, 25)}}</td>
                <td>{{$book->pages_count}}</td>
                <td>{{$book->in_all}}/{{(isset($taken[$book->id]))? count($taken[$book->id]) : 0}}</td>
                <td title="@isset($genres[$book->id])@foreach($genres[$book->id] as $genre)@if(!$loop->first), @endif{{$allGenres[$genre->genre_id]->name}}@endforeach @endisset">
                    Кол-во: @isset($genres[$book->id]){{count( $genres[ $book->id ])}} @else 0 @endisset
                </td>
                <td>{{$book->inventory_number}}</td>
            </tr>
        @endforeach
    </table>
    <div class="secondPag">{{$books->links()}}</div>
</div>
@endsection






