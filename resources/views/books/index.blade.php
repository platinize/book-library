
<div class="wrapper">
    <div class="container books content">
        <div class="booksBlock">
            {{$books->links()}}
            <div class="search">
                <form method="post">
                    <input type="text" name="search" class="form-control">
                    <input type="submit" value="Поиск" class="btn btn-primary">
                    {{ csrf_field() }}
                </form>
            </div>
            <div class="allBooks">
                @foreach($books as $book)
                    <div class="bookBlock">
                        <p class="title_book"><a href="{{route('showBook', $book->id)}} " title="{{$book->title_book}}">{{str_limit($book->title_book, 25)}}</a></p>
                        <span>
                    <a href="{{route('showBook', $book->id)}}"><img src="{{URL::to('../')}}/{{$book->image}}" style="width: 100px"></a>
                    Автор: {{$book->author}}</span>
                        <p><span class="description">{{str_limit($book->description, 50)}}</span></p>
                        <p>
                            @isset($genres[$book->id])@foreach($genres[$book->id] as $genreId)@if(!$loop->first), @endif{{$allGenres[$genreId->genre_id]->name}}@endforeach @endisset
                        </p>
                    </div>
                @endforeach
            </div>
            <div class="secondPag">{{$books->links()}}</div>
        </div>
        <div class="genres sidebar">
            <div class="panel-heading">Жанры</div class="panel-heading">
            <ul>
                @foreach($usedGenres as $genre)
                    <li><a href="{{route('groupByGenre', $genre->genre_id)}}" class="navigation">{{$allGenres[$genre->genre_id]['name']}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>



