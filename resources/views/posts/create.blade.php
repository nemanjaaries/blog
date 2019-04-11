@extends('layouts.app')

@section('content')
    <h1>Post</h1>  
    {!! Form::open(['action' => 'PostController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{ Form::label('title', 'Title', ['class' => 'control-label']) }}
            {{ Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title', 'autocomplete' => 'off']) }}
        </div>
        <div class="form-group">
            {{ Form::label('body', 'Body', ['class' => 'control-label']) }}
            {{ Form::textarea('body', '', ['class' => 'form-control', 'id' => 'article-ckeditor', 'placeholder' => 'Your text...']) }}
        </div>
        <div class="form-group">
            {{ Form::file('cover_img', ['class' => 'form-control-file']) }}
        </div>
        <div class="form-group">
            {{ Form::submit('Create', ['class' => 'btn btn-primary']) }}
        </div>
    {!! Form::close() !!}
@endsection