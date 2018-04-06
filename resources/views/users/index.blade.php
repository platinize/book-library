@extends('layouts.footer')
@extends('layouts.header')
@section('content')
@if( count($users) != 0 )
<h1>Управление пользователями ({{$role}}s)</h1>
<p><a href="{{route('admin')}}" class="navigation">Вернуться</a>
@if($users->first()->role != 'admin')
    <p>
        <a href="{{ route('createUser') }}" class="navigation" title="Добавить пользоватля не желающего иметь личный кабинет">
            Добавить пользоватля
        </a>
    </p>
@endif
<div>
    <div class="search">
        <form method="post">
            <input type="text" name="search" class="form-control">
            <input type="submit" value="Поиск" class="btn btn-primary">
            {{ csrf_field() }}
        </form>
    </div>
    <table cellspacing="0" border="1" cellpadding="10" class="adminTable">
        <tr height="50px" style="text-align: center">
            <td>id</td>
            <td>ФИО</td>
            <td>E-mail</td>
            <td>Дата регистрации</td>
            <td>Номер телефона</td>
            <td>Номер читательского</td>
            <td>Книг взято</td>
            <td>Книг просрочено</td>
            <td>Исключить</td>
        </tr>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td title="{{$user->name}}"><a href="{{route('showUser', $user->id)}}">{{str_limit($user->name, 15)}}</a></td>
                    <td title="{{$user->email}}">{{str_limit($user->email, 5)}}</td>
                    <td title="{{$user->created_at}}">{{str_limit($user->created_at, 11)}}</td>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->card_number}}</td>
                    <td>@isset($books[$user->id]) {{count($books[$user->id])}} @endisset</td>
                    <td>@isset($overdue[$user->id]) {{count($overdue[$user->id])}} @endisset</td>
                    <td class="delete"><a href="{{route('deleteUser', $user->id)}} " onClick="return window.confirm('Исключить?');">Х</a></td>
                </tr>
            @endforeach

    </table>
    <div class="secondPag">{{$users->links()}}</div>
</div>
@else
    <p>Пользователей не найдено</p>
    <p><a href="{{route('admin')}}" class="navigation">Вернуться</a>
@endif
@endsection






