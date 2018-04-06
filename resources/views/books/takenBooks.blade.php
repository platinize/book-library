@extends('layouts.footer')
@extends('layouts.header')
@section('content')
<h1>Взятые книги</h1>
<p><a href="{{route('admin')}}" class="navigation">Вернуться</a>
<div class="booksTable">
    {{$taken->links()}}
    <table cellspacing="0" border="1" cellpadding="10" class="adminTable">
        <tr>
            <td>Когда взяли</td>
            <td>Книга</td>
            <td>Читатель</td>
            <td>Вернуть до</td>
        </tr>
        @foreach($taken as $took)
            <tr>
                <td>{{$took->created_at}}</td>
                <td><a href="{{route('showBook', $took->book_id)}}" title="Перейти на книгу">{{$books[$took->book_id]->title_book}}</a></td>
                <td><a href="{{route('showUser', $took->user_id)}}" title="Перейти на книгу">{{$users[$took->user_id]->name}}</a></td>
                <td @if(time()>strtotime($took->return_date)) style="background: #d9534f " @endif>{{$took->return_date}}</td>
            </tr>
        @endforeach
    </table>
    <div class="secondPag">{{$taken->links()}}</div>
</div>
@endsection

