<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Psy\CodeCleaner\ReturnTypePass;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [            
            new Middleware('auth', except: ['index', 'show'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts = Post::orderBy('created_at', 'desc')->get();        
        // $posts = Post::latest()->get();
        $posts = Post::latest()->paginate(6);      

        return view('posts.index', [ 'posts' => $posts ] );
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        

        // validate
        $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required'],
            'image' => ['nullable', 'file', 'max:10240', 'mimes:png,jpg,jpeg,webp' ]
        ]);

        // Store image if exists 
        $path = null;        
        if( $request->hasFile('image') )
        {
            $path = Storage::disk('public')->put('posts_images', $request->image );
        }
     

        // create a post
        Auth::user()->posts()->create([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $path
        ]);        

        // redirect to dashboard
        return back()->with('success', 'Your post was created');


    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // Check if the user is authorized to perform this action
        Gate::authorize('modify', $post);
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Check if the user is authorized to perform this action
         Gate::authorize('modify', $post);

        // validate
        $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required'],
            'image' => ['nullable', 'file', 'max:10240', 'mimes:png,jpg,jpeg,webp' ]
        ]);

        // Store image if exists 
        $path = $post->image ?? null;        
        if( $request->hasFile('image') )
        {
            if($post->image)
            {
                Storage::disk('public')->delete($post->image);
            }
            $path = Storage::disk('public')->put('posts_images', $request->image );
        }

        // update a post
        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $path
        ]);

        // redirect to dashboard
        return redirect()->route('dashboard')->with('success', 'Your post is updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Check if the user is authorized to perform this action
         Gate::authorize('modify', $post);

        // Delete post image if exists
        if($post->image)
        {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return back()->with('delete', 'Post deleted');
    }
}
