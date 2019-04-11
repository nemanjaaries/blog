@extends('layouts.app')

@section('content')
    <h1>Post</h1> 
    @if(count($posts) > 0)
        @foreach($posts as $post)
            <div class="row">
                <div class="col-4">
                    <div class="card mb-2">
                        <img class="card-img-top" src="/storage/cover_images/{{$post->cover_img}}" alt="Card image cap" width="300">
                        <div class="card-body">
                        <h3 class="card-title"><a class="link" href="post/{{$post->id}}">{{$post->title}}</a></h3>
                        <small>writen on {{$post->created_at}} by {{$post->user->name}}</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{ $posts->links() }}
    @else
        <p>There is no posts</p>
    @endif
    
@endsection