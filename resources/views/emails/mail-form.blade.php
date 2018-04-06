@extends('layouts.footer')
@extends('layouts.header')
@section('content')
<h1>Отправка письма</h1>
{!! Form::open(['url' => '/admin/messege']) !!}
    {{Form::text('name')}}
    {{Form::text('email')}}
    {{Form::textarea('msg')}}
    {{Form::submit('send')}}

{!! Form::close() !!}
@endsection
