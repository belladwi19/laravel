@extends('templates.default')

@section('content')
    <h3>{{$post->title}}</h3>
    <p>{{$post->content}}</p>
@endsection