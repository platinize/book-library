@extends('layouts.footer')
@extends('layouts.header')

@section('content')
<h1>Профиль читатля</h1>
<div class="userProfile">
    @if($role == 'admin')
        <p>
            <a href="{{route('users', $user->role)}}" class="navigation">Вернуться</a>
            <a href="{{route('editUser', $user->id)}}" class="navigation">Редактировать профиль</a>
        </p>
        <div>ID: {{$user->id}}</div>
        <div>Должность: {{$user->role}}</div>

    @endif
    <div>
        <p><img src="{{URL::to('../')}}/{{$user->photo}}" style="width: 150px"></p>
        <p>ФИО: {{$user->name}}</p>
        <p>E-mail: {{$user->email}}</p>
        <p>Телефон: {{$user->phone}}</p>
        <p>Домашний адрес: {{$user->address}}</p>
        <p>Номер читательского: {{$user->card_number}}</p>
    </div>
    <div>
        @if($role == 'admin') <p><a href="{{route('createBookUser', $user->id)}}" class="navigation">Выдать книгу</a></p> @endif
        <table cellspacing="0" border="1" cellpadding="10" class="books">
            <tr>
                <td colspan="2">Взятые книги</td>
                <td colspan="2">Вернуть до</td>
            </tr>
            @if($usersBooks->isEmpty())
                <tr>
                    <td colspan="2">Нет</td>
                    <td colspan="2"> - </td>
                </tr>
            @endif
            @foreach($books as $book)
                <tr>
                    <td><a href="{{route('showBook', $book->id)}}">{{$book->title_book}}</a></td>
                    <td>{{$book->author}}</td>
                    <td @if(time()>strtotime($booksInfo[$book->id]['return_date'])) style="background: #ff6e9c " @endif>{{$booksInfo[$book->id]['return_date']}}</td>
                    @if($role == 'admin')<td class="delete"><a href="{{route('destroyBookUser', $booksInfo[$book->id]['id'])}} " onClick="return window.confirm('Уверены?');">Х</a></td>@endif
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection