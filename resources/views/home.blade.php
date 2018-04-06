@extends('layouts.footer')
@extends('layouts.header')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default"><h1>Ваш профиль</h1>
                <div class="panel-heading"> </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div>
                    <img src="{{URL::to('../')}}/{{$user->photo}}" style="width: 150px;">
                    <span style="cursor:pointer;color: #c7254e" id="setPhoto">
                        @if($user->photo == 'storage/app/user_photo/photo.jpg')Поставить @else Изменить @endif фото
                    </span>
                    <p>ФИО: {{$user->name}}</p>
                    <p>Email: {{$user->email}}</p>
                    <p>Телефон: {{$user->phone}}</p>
                    <p>Домашний адрес: {{$user->address}}</p>
                    <p>Номер читательского: {{$user->card_number}}</p>
                </div>
                <div>
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
                        @foreach($usersBooks as $usersbook)
                            <tr>
                                <td><a href="{{route('showBook', $usersbook->book_id)}}">{{$books[$usersbook->book_id]->title_book}}</a></td>
                                <td>{{$books[$usersbook->book_id]->author}}</td>
                                <td @if(time()>strtotime($usersbook->return_date)) style="background: #ff6e9c " @endif>{{$usersbook->return_date}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class='setPhoto' align="center">
    <form method="post" action="" id="setPhoto" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="file" name="photo">
        <input type="submit"  value="Подтвердить" class="btn btn-primary">
    </form>
    <input type="button" class="subm no btn btn-primary" value="Отмена">
    @if($user->photo != 'storage/app/user_photo/photo.jpg')<p><a href="{{route('deletePhoto')}}" class="delete">Удалить</a></p>@endif

</div>
<script>
    $(document).ready(function(){
        $('.no').click(function(){
            $('.setPhoto').fadeOut('slow');
        });
        $('#setPhoto').click(function(e){
            $('.setPhoto').fadeIn('slow');
            $('.setPhoto').css({
                'top':e.pageY,
                'left':e.pageX
            });
        });
    });
</script>
@endsection
