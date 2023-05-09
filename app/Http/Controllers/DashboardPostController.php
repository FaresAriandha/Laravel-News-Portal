<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use App\Models\Category;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Storage;
use Hamcrest\Core\AllOf;

class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Posts::where('user_id', auth()->user()->id)->get()[0]->category);
        return view('dashboard.posts.index', [
            "posts" => Post::where('user_id', auth()->user()->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.posts.create', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            "title" => "required|max:255|unique:posts",
            "category_id" => "required",
            "slug" => "required|unique:posts",
            "image" => "image|file|max:2048",
            "body" => "required"
        ]);

        // $validateData['image'] = $request->file('image')->store('post_images');
        $validateData['image'] = $request->file('image');
        if (!Storage::disk('public_uploads')->put('', $validateData['image'])) {
            dd($validateData['image']);
            return false;
        }
        $filename = "/uploads/" . Storage::disk('public_uploads')->put('', $validateData['image']);
        $validateData['image'] = $filename;
        $validateData['excerpt'] = Str::limit(strip_tags($request->body), 100);
        $validateData['user_id'] = auth()->user()->id;

        Post::create($validateData);

        return redirect('/dashboard/posts')->with('success', 'New post has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if ($post->author->id !== auth()->user()->id) {
            return redirect('/dashboard/posts');
            // abort(403);
        }

        return view('dashboard.posts.detail', [
            "post" => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('dashboard.posts.edit', [
            "post" => $post,
            "categories" => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if ($post->author->id !== auth()->user()->id) {
            return redirect('/dashboard/posts');
            // abort(403);
        }

        $rules = [
            "category_id" => "required",
            "body" => "required",
            "image" => "image|file|max:2048"
        ];

        if ($request->title != $post->title) {
            $rules['title'] = "required|max:255|unique:posts";
        }

        if ($request->slug != $post->slug) {
            $rules['slug'] = "required|unique:posts";
        }

        $updateData = $request->validate($rules);
        if ($request->file('image')) {
            if ($post->image) {
                $filename = explode('/', $post->image);
                $filename = end($filename);
                Storage::disk('public_uploads')->delete($filename);
            }
            if (!Storage::disk('public_uploads')->put('', $request->image)) {
                dd($request->image);
                return false;
            }
            $filename = "uploads/" . Storage::disk('public_uploads')->put('', $request->image);
            $updateData['image'] = $filename;
        }
        $updateData['excerpt'] = Str::limit(strip_tags($request->body), 100);
        $updateData['user_id'] = auth()->user()->id;

        $post->update($updateData);
        return redirect('/dashboard/posts')->with('success', 'One post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::delete($post->image);
        }
        // Post::destroy($post->id);
        $post->delete();
        return redirect('/dashboard/posts')->with('success', 'Post successfully deleted');
    }

    public function checkSlug(Request $request)
    {
        // return $request->title;
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        return response()->json(["slug" => $slug]);
    }
}
