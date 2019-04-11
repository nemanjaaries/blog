@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                <a href="post/create" class="btn btn-primary">Create Post</a> 
                </div>
            </div>
            @if($posts)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{$post->title}}</td>
                                <td><a href="post/{{$post->id}}/edit" class="btn btn-warning">Edit</a></td>
                                <td>
                                    {!! Form::open(['action' => ['PostController@destroy', $post->id], 'method' => 'POST']) !!}
                                        {{ Form::hidden('_method', 'DELETE')}}
                                        {{ Form::submit('Create', ['class' => 'btn btn-danger']) }}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>You have no posts</p>
            @endif

        </div>
    </div>
</div>
@endsection
