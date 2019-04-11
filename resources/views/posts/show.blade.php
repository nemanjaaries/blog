@extends('layouts.app')

@section('content')
    <h1>Post</h1>  
    <a href="/post" class="btn btn-light">Go back</a>
    <div class="card mb-2">
        <img class="card-img-top" src="/storage/cover_images/{{$post->cover_img}}" alt="Card image cap" width="300">
        <div class="card-body">
        <h3 class="card-title">{{$post->title}}</h3>
            <p class="card-text">{!!$post->body!!}</p>
            <small>writen on {{$post->created_at}}</small>
        </div>
    </div>
    @if(!Auth::guest())
        @if(auth()->user()->id == $post->user_id)
            <a href="{{$post->id}}/edit" class="btn btn-warning float-left">Edit</a>
            {!! Form::open(['action' => ['PostController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right']) !!}
                <div class="form-group">
                    {{ Form::hidden('_method', 'DELETE')}}
                    {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                </div>
            {!! Form::close() !!}
        @endif
    @endif
@endsection