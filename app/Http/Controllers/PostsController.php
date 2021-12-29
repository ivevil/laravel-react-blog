<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Categories;
use App\Models\Posts;
use App\Models\User;
use App\Models\Media;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Routing\UrlGenerator;

class PostsController extends Controller
{
    use UploadTrait;

    public function index()
    {
        $posts = Posts::all()->sortByDesc('created_at')->paginate(10);

        return view('admin.posts')->with('posts', $posts);
    }

    public function create()
    {
        $categories = Categories::all();
        $media = Media::all();

        return view ('admin.create-post')->with([
            'categories' => $categories,
            'media' => $media
            ]);
    }

    public function store(Request $request)
    {

        $data = $request->input();
        $post = new Posts();
        $post->title = $data['title'];
        $post->body = $data['body'];
        $category = Categories::find($data['categoryid']);
        $post->Categories()->associate($category);

        if ($request->has('featured_image')) {
            $post->featured_image = $request->featured_image;
        } else {
            $post->featured_image = '';
        }

        $user = Auth::user();

        if($user == null) {
            $user = User::find(1);
        }
        $post->User()->associate($user);

        $post->save();

        return redirect('/posts');
    }

    public function edit(Request $request)
    {
        $id = $request->input("id");
        $post = Posts::find($id);
        $categories = Categories::all();
        $media = Media::all();

        return view('admin.edit-post')->with([
            'categories' => $categories,
            'post' => $post,
            'media' => $media
            ]);
    }

    public function update(Request $request)
    {
        $post = Posts::find($request->id);

        $category = Categories::find($request->categoryid);
        $post->Categories()->associate($category);

        $post->update(request()->all());

         if ($request->has('featured_image')) {
            $post->featured_image = $request->featured_image;
        } else {
            $post->featured_image = '';
        }

        $post->save();

        return redirect()->back()->with('message', 'Post successfully updated.');
    }

    public function destroy(Request $request)
    {
        $id = $request->input("id");
        $post = Posts::find($id);

        if ($post != null) {
            $post->delete();
        }
        return back();

    }

    public function show(Posts $post)
    {

        return view('show')->with('post', $post);
    }
}
