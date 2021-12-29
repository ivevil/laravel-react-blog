<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Categories;
use App\Models\Posts;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Categories::all()->paginate(10);

        return view('admin.categories')->with('categories', $categories);
    }

    public function create()
    {
        $categories = Categories::all();

        return view ('admin.create-category')->with('categories', $categories);
    }

    public function store(Request $request)
    {
        Categories::create(request()->all());

        return redirect('/categories');
    }

    public function edit(Request $request)
    {
        $id = $request->input("id");
        $category = Categories::find($id);

        return view('admin.edit-category')->with('category', $category);
    }

    public function update(Request $request)
    {
        $id = $request->input("id");
        $category = Categories::find($id);
        $category->update(request()->all());

        return redirect('/categories')->with('message', 'Category is successfully updated.');
    }

    public function destroy(Request $request)
    {
        $id = $request->input("id");
        $category = Categories::find($id);

        $posts = Posts::all();

        foreach($posts as $post) {
            if($post->categoryid != $category->id) {
                if($category != null) {
                    $category->delete();
                    return redirect('/categories')->with('message', 'Category is successfully deleted.');
                }
            } else {
                $danger = true;
                return redirect()->back()->with('dangermessage', 'This category is related to post(s).');
            }
        }
    }

    public function show(Categories $category)
    {
        $posts = Posts::where("categoryid", "=", $category->id)
        ->orderBy('created_at', 'desc')
        ->paginate(6);

        return view('category')->with([
            'category' => $category,
            'posts' => $posts
                                    ]);
    }
}
