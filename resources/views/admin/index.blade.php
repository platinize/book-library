@extends('layouts.footer')
@extends('layouts.header')
@section('content')
<h1>Админка</h1>
<div>
    <p>{{$user->name}}</p>
    <p>{{$user->email}}</p>
</div>
<p><a href="{{route('users', 'user')}}" class="navigation">Посетители</a>
<p><a href="{{route('users', 'admin')}}" class="navigation">Администрация</a>
<p><a href="{{route('booksAdmin', ['title_book', 'asc'])}}" class="navigation">Управление книгами</a></p>
<p><a href="{{route('taken')}}" class="navigation">Взятые книги</a></p>
@endsection






