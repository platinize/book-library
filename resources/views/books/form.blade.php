@extends('layouts.footer')
@extends('layouts.header')
@section('content')
@if(isset($book))
    <h1>Редактрирование книги "{{$book->title_book}}"(id{{$book->id}})</h1>
    <p><a href="{{route('showBook', $book->id)}}">Вернуться</a></p>
@else
    <h1>Добавление книги</h1>
    <p><a href="{{route('booksAdmin', ['title_book', 'asc'])}}">Вернуться</a></p>
@endif
<div class="bookForm">
    <form method="post" enctype="multipart/form-data">
        <div><input type="hidden" name="id" value="@isset($book){{$book->id}}@endisset"></div>
        <div>
            <p>Название книги*</p>
            <textarea rows="3" name="title_book" required class="form-control">@isset($book){{$book->title_book}}@endisset</textarea>
        </div>
        <div>
            <p>Автор*</p>
            <textarea rows="2" name="author" class="form-control" required>@isset($book){{$book->author}}@endisset</textarea>
        </div>
        <div>
            <p>Жанр</p>
            <select name="genres[]" multiple size="5" class="form-control">
                <option  value="no" @if(!isset($book))selected @endif >Не выбран</option>
                @foreach($allGenres as $oneGenre)
                    <option  value="{{$oneGenre->id}}" @if(isset($book)) @if(in_array($oneGenre->id,$genresId)) selected @endif @endif> {{$oneGenre->name}} </option>
                @endforeach
            </select>
        </div>
        <div>
            <p>Описание</p>
            <textarea rows="10" spellcheck="true" name="description" class="form-control" >@isset($book){{$book->description}}@endisset</textarea>
        </div>
        <div>
            <p>Дата издания книги</p>
            <input type="date" name="publication_date" class="form-control" @isset($book)value="{{$book->publication_date}}"@endisset >
            <p>Дата написания произведения</p>
            <input type="date" name="creation_date" class="form-control" @isset($book)value="{{$book->creation_date}}"@endisset >
            <p>Издательство</p>
            <input type="text" name="publisher" class="form-control" @isset($book)value="{{$book->publisher}}"@endisset >
            <p>Количество страниц</p>
            <input type="number" min="0" name="pages_count" class="form-control" @isset($book)value="{{$book->pages_count}}"@endisset >
            <p>Количество имеющихся книг</p>
            <input type="number" min="0" name="in_all" class="form-control" @isset($book)value="{{$book->in_all}}"@endisset >
        </div>
        <div>
            <p>Обложка</p>
            <p>
                @isset($book) @if($book->image != '')
                    <img src="../../../{{$book->image}}" style="max-width:150px">
                    <label style="cursor:pointer"><input type="checkbox" name="defaultImg" value="yes">Сбросить обложку до стандартной</label>
                @endif @endisset
            </p>
        </div>
        <div><input type="file" name="image"></div>

        {{ csrf_field() }}
        <div><input type="submit" class="btn btn-primary" value="@if(isset($book)) Сохранить @else Добавить @endif"></div>
    </form>
</div>
@endsection