@extends('layouts.footer')
@extends('layouts.header')
@section('content')
@if(isset($user))
    <h1>Редактрирование профиля (id{{$user->id}})</h1>
@else
    <h1>Регистрация читателя</h1>
@endif
<div class="userForm">
    @isset($user)
        <p><a href="{{route('showUser', $user->id)}}">Вернуться</a></p>
    @else
        <p><a href="{{route('users', 'user')}}" class="navigation">Вернуться</a>
    @endisset
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" enctype="multipart/form-data">
        @isset($user)<div><input type="hidden" name="id" value="{{$user->id}}"></div>@endisset
        <div>
            <label><p>ФИО*</p>
            <textarea rows="1" name="name" class="form-control" required>@isset($user){{$user->name}}@endisset</textarea></label>
        </div>
        <div>
            <label><p>E-mail</p>
            <textarea rows="1" name="email" class="form-control">@isset($user){{$user->email}}@endisset</textarea></label>
        </div>
        <div>
            <p>Должность</p>
            <select name="role" size="2">
                <option  value="user" selected>Читатель</option>
                <option  value="admin" @if(isset($user) && $user->role ==  'admin') selected @endif>Администрация</option>
            </select>
        </div>
        <div>
            <label><p>Номер читательского</p>
            <textarea rows="1" name="card_number" class="form-control">@isset($user){{$user->card_number}}@endisset</textarea></label>
        </div>
        <div>
            <label><p>Домашний адрес*</p>
            <textarea rows="4" name="address" class="form-control">@isset($user){{$user->address}}@endisset</textarea></label></label>
        </div>
        <div>
            <label><p>Телефон</p>
            <textarea rows="1" name="phone" class="form-control">@isset($user){{$user->phone}}@endisset</textarea></label></label>
        </div>
        <div>
            @isset($user) @if($user->photo != '')
                <img src="{{URL::to('../')}}/{{$user->photo}}" style="max-width:150px">
                <label style="cursor:pointer"><input type="checkbox" name="defaultPhoto" value="yes">Удалить фото</label>
            @endif @endisset
        </div>
        <div><input type="file" name="photo"></div>
        {{ csrf_field() }}
        <div><input type="submit" class="btn btn-primary" value="@if(isset($user)) Сохранить @else Добавить @endif"></div>
    </form>
</div>
@endsection
