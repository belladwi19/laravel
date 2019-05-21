<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->paginate(10);

        return view('admin.post.index', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.post.create');
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
            'title' => 'required|min:10',
            'content' =>'required|min:10',
        ], [
            'required' =>'attribute Harus diisi',
        ]);
        $imagePath = $request->file('image')->store('post');

        $post = new Post;
        $post->title = $request->title;
        $post->image = $imagePath;
        $post->slug = str_slug($request->title);
        $post->content = $request->content;
        $post->save();

        //method create
        //Post::create(request->only('title','content'));

        return redirect()->route('admin.post.index')->with('info','Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
       // $post = Post::find($id);

        return view('admin.post.edit', [
            'post'=>$post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->validate($request, [
            'title' => 'required|min:10',
            'content' =>'required|min:10',
        ], [
            'required' =>'attribute Harus diisi',
        ]);

       // $post = Post::find($id);
        $post->title = $request->title;
        $post->slug = str_slug($request->title);
        $post->content = $request->content;
        $post->save();

        //method create
        //Post::create(request->only('title','content'));

        return redirect()->route('admin.post.index')->with('info','Berhasil dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //$post = Post::find($id);

        $post->delete();

        return redirect()->route('admin.post.index')->with('danger','Berhasil Dihapus');
    }
}
