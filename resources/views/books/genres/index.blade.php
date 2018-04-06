@extends('layouts.footer')
@extends('layouts.header')
@section('content')
<h1>Жанры</h1>
<p><a href="{{route('booksAdmin', ['title_book', 'asc'])}}" class="navigation">Вернуться</a>
<div class="addGenre">
    <form method="post" action="{{route('storeGenre')}}">
        <label>
            Добавить жанр
            <input type="text" name="name" class="form-control">
        </label>
        <input type="submit"  value="Добавить" class="btn btn-primary">
        {{ csrf_field() }}

    </form>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="adminGanres">
    @foreach($genres as $genre)
    <p class="adm_genre" style="display:flex;float:left;margin: 5px 10px"><span href="" id="{{$genre->id}}" title="{{$genre->name}}" class="show" style="cursor:pointer">{{$genre->name}}</span></p>
    @endforeach
</div>
<div class='option' align="center">
    <form method="post" action="" id="updateGenre">
        {{ csrf_field() }}
        <p><input type="hidden" class="id" value="" name="id"></p>
        <p><input type="text" class="name" id="name"  name="name" style="width: 300px"></p>
        <input type="submit"  value="Пересохранить" class="btn btn-primary">
    </form>
    <p><a href="" class="delete">Удалить</a></p>
    <p><input type="button" class="subm no btn btn-primary" value="Отмена"></p>
</div>
    <script>
        $(document).ready(function(){
            $('.no').click(function(){
                $('.option').fadeOut('slow');
            });
            $('.show').click(function(e){
                $('input.id').val($(this).attr('id'));
                $('input#name').val($(this).attr('title'));
                $('a.delete').attr('href', window.location.href+'/delete/'+$(this).attr('id'));
                $('#updateGenre').attr('action', window.location.href+'/genres-update/'+$(this).attr('id'));
                $('.option').fadeIn('slow');
                $('.option').css({
                    'top':e.pageY,
                    'left':e.pageX
                });
            });
        });
    </script>
@endsection




