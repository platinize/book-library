
@extends('layouts.footer')
@extends('layouts.header')

@section('content')
<div class="wrapper">
    <div class="container books ">

        <h1>{{$book->title_book}}</h1>
        @if($role == 'admin')
            <p><a href="{{route('booksAdmin', ['title_book', 'asc'])}}">Вернуться</a></p>
            <p><a href="{{route('editBook', $book->id)}}">Редактировать</a></p>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <p>
            <form method="post" action="{{route('deleteBook', $book->id)}}">
                <input type="hidden" value="{{$book->id}}" name="book_id">
                <input type="submit" value="Удалить книгу" onClick="return window.confirm('Удалить книгу?');" class="btn btn-primary">
                {{ csrf_field() }}
            </form>
            </p>
            <p>ID: {{$book->id}}</p>
            <p>Всего книг: {{$book->in_all}}</p>
            <p>На руках: {{count($taken)}} (
                @foreach($usersTook as $user)
                    @if(!$loop->first), @endif <a href="{{route('showUser', $user->id)}}">{{$user->name}}</a>
                @endforeach
                @foreach($usersDetained as $user)
                    @if(!$loop->first), @endif <a href="{{route('showUser', $user->id)}}" style="color:darkred">{{$user->name}}</a>
                @endforeach )
            </p>
        @endif
        <div>
            <p><img src="{{URL::to('../')}}/{{$book->image}}" style="max-width: 500px"></p>
            <p>Автор: {{$book->author}}</p>
            <p>@foreach($genres as $genre)@if(!$loop->first), @endif{{$allGenres[$genre->genre_id]->name}}@endforeach</p>
            <p>Описание: {{$book->description}}</p>
            <p>Издатель: {{$book->publisher}}</p>
            <p>Количество страниц: {{$book->pages_count}}</p>
            <p>Инвентарный номер: {{$book->inventory_number}}</p>
        </div>
    </div>
</div>
@endsection








