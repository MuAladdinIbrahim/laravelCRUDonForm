<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePostRequest;

class PostController extends Controller
{
    public function index()
    {
        // $posts = DB::table('posts')->paginate(2);
        // $posts = Post::all()->paginate(2);
        $posts = Post::paginate(2);
        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        $users = User::all();
        return view('posts.create', [
            'users' => $users
        ]);
    }

    public function show()
    {
        //take the id from url param
        $request = request();
        $postId = $request->post;

        //query to retrieve the post by id
        $post = Post::find($postId);
        // $post = Post::where('id', $postId)->get();
        // $postSecond = Post::where('id', $postId)->first();

        //send the value to the view
        return view('posts.show', [
            'post' => $post,
        ]);
    }
    public function store(StorePostRequest $spr)
    {
        //get the request data
        $request = request();
        // $validateData = $request->validate([
        //     'title' => 'required|min:3',
        //     'description' => 'required|min:5'
        // ], [
        //     'title.min' => 'Please the title has minimum of 3 characters',
        //     'title.required' => 'Please Enter the title field',
        //     'description.min' => 'Please the title has minimum of 5 characters',
        //     'description.required' => 'Please Enter the description field'
        // ]);

        //store the request data in the db
        // Post::create([
        //     'title' => $request->title,
        //     'description' =>  $request->description,
        //     'user_id' =>  $request->user_id,
        // ]);

        Post::create($request->only(['title', 'description', 'user_id']));
        //redirect to /posts
        return redirect()->route('posts.index');
    }

    public function edit()
    {
        $request = request();
        $postId = $request->post;
        $post = Post::find($postId);
        $user_id = $post->user_id;
        $user = User::find($user_id);
        return view('posts.edit', [
            'post' => $post,
            'user' => $user
        ]);
    }

    public function update()
    {
        $request = request();
        // dd($request);
        $postId = $request->post;
        $post = Post::find($postId);
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id =  $request->user_id;
        $post->save();
        return redirect()->route('posts.index');
    }

    public function destroy()
    {
        $request = request();
        $postId = $request->post;
        $post = Post::find($postId);
        $post->delete();
        return redirect()->route('posts.index');
    }
}
