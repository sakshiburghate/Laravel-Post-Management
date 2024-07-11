<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Auth::user()->isAdmin() ? Post::paginate(5) : Auth::user()->posts()->paginate(3);
        return view('posts.index', compact('posts'));
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
        $request->validate([
            'title' => 'required|max:255|unique:posts,title',
            'body' => 'required',
        ], [
            'title.unique' => 'The title has already been taken. Please choose a different one.',
        ]);
        
        $data = $request->all();
        $data['author'] = Auth::user()->name;
        $data['slug'] = Str::slug($request->input('title'), '-');
    
        Auth::user()->posts()->create($data);
        $request->session()->flash('alert-success', 'Post created successfully.');
        return redirect()->route('posts.index');
    }
    
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($identifier)
    {
        if (is_numeric($identifier)) {
            $post = Post::findOrFail($identifier);
        } else {
            $post = Post::where('slug', $identifier)->firstOrFail();
        }

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
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
        $this->authorize('update', $post);
    
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
    
        $data = $request->all();
        $data['author'] = $post->author; 
        $data['slug'] = Str::slug($request->input('title'), '-');
    
        $post->update($data);
        $request->session()->flash('alert-success', 'Post updated successfully.');
        return redirect()->route('posts.index');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        session()->flash('alert-danger', 'Post deleted successfully.');
        return redirect()->route('posts.index');
    }

}
