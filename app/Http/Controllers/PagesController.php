<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use App\Models\Taxonomies;
use App\Models\Posts;
use App\Models\Menus;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        $pages = Pages::all()->paginate(10);

        return view('admin.pages')->with('pages', $pages);
    }

    public function create()
    {
        $pages = Pages::all();

        return view ('admin.create-page')->with('pages', $pages);
    }

    public function store(Request $request)
    {
        Pages::create(request()->all());

        return redirect('/pages');
    }

    public function edit(Request $request)
    {
        $id = $request->input("id");
        $page = Pages::find($id);

        return view('admin.edit-page')->with('page', $page);
    }

    public function update(Request $request)
    {
        $id = $request->input("id");
        $page = Pages::find($id);
        $page->update(request()->all());

        return redirect('/pages')->with('message', 'Page is successfully updated.');
    }

    public function destroy(Request $request)
    {
        $id = $request->input("id");
        $page = Pages::find($id);

        $hasPages = $page->menus()->where('pages_id', $id)->exists();

        if(!($hasPages)) {
            $page->delete();
            return redirect('/pages')->with('message', 'Page is successfully deleted.');
            } else {
                $danger = true;
                return redirect()->back()->with('dangermessage', 'This page is related to menu(s).');
            }
    }
}
