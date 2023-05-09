<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // $posts = Post::latest();
        $title = '';
        if(request('category'))
        {
            $title = Category::firstWhere('slug', request('category'))->name;
            $title = " in $title";
        }

        if(request('author'))
        {
            $title = User::firstWhere('username', request('author'))->name;
            $title = " by $title";
        }

        $req = ['search', 'category', 'author'];

        return view('posts', [
            "active" => "Posts",
            "title" => "All Posts $title",
            "posts" => Post::latest()->filter(request($req))->paginate(7)->withQueryString()
            // "posts" => Post::latest()->get()
            // "posts" => $posts->get()
        ]);
    }

    public function singlePost(Post $post)
    {
        return view('post', [
            "title" => "Posts",
            // "post" => Post::where('slug', $slug)->get()[0]
            "post" => $post
        ]);
    }
}
