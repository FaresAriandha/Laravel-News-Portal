<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Storage;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.categories.index', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');
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
            "name" => "required|max:255|unique:categories",
            "slug" => "required|unique:categories",
            "image" => "image|file|max:2048",
        ]);

        if ($request->file('image')) {
            $validateData['image'] = $request->file('image')->store('categories_images');
        }
        Category::create($validateData);

        return redirect('/dashboard/categories')->with('success', 'New categories has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit',[
            "category" => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $rules = [
            "image" => "image|file|max:2048",
        ];

        if ($request->name != $category->name) {
            $rules['name'] = "required|max:255|unique:categories";
        }

        if ($request->slug != $category->slug) {
            $rules['slug'] = "required|unique:categories";
        }

        $validateData = $request->validate($rules);
        if ($request->file('image')) {
            if ($category->image) {
                Storage::delete($category->image);
            }
            $validateData['image'] = $request->file('image')->store('categories_images');
        }
        $category->update($validateData);

        return redirect('/dashboard/categories')->with('success', 'New categories has been added');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->image) {
            Storage::delete($category->image);
        }
        Category::destroy($category->id);
        return redirect('/dashboard/categories')->with('success', 'One category successfully deleted');
    }

    public function checkSlug(Request $request)
    {
        // return $request->title;
        $slug = SlugService::createSlug(Category::class, 'slug', $request->name);
        return response()->json(["slug" => $slug]);
    }
}
