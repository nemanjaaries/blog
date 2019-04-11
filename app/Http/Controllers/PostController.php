<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Post;


class PostController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(8);

        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:30',
            'body' => 'required',
            'cover_img' => 'image|nullable|max:1999'
        ]);

        if($request->hasFile('cover_img')){
            
            $fileNameWithExt = $request->file('cover_img')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $fileExt = $request->file('cover_img')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;

            //Upload img
            $path = $request->file('cover_img')->storeAs('public/cover_images', $fileNameToStore);

        }else{
            $fileNameToStore = 'no_image.jpg';
        }
        
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_img = $fileNameToStore;
        $post->save();

        return redirect('post')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        if($post->user_id !== auth()->user()->id){
            return redirect('post')->with('error', 'Unauthorized access');
        }

        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:30',
            'body' => 'required',
            'cover_img' => 'image|nullable|max:1999'
        ]);

        if($request->hasFile('cover_img')){

            $fileNameWithExt = $request->file('cover_img')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $fileExt = $request->file('cover_img')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;

            //Upload img
            $path = $request->file('cover_img')->storeAs('public/cover_images', $fileNameToStore);

        }
        
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_img')){
            $post->cover_img = $fileNameToStore;
        }
        $post->save();

        return redirect('post')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if($post->user_id !== auth()->user()->id){
            return redirect('post')->with('error', 'Unauthorized access');
        }

        if($post->cover_img != 'no_image.jpb'){
            Storage::delete('/public/cover_images/'.$post->cover_img);
        }
        
        $post->delete();
        return redirect('post')->with('success', 'Post Deleted');
    }
}
