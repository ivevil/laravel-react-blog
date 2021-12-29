<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Taxonomies;
use App\Models\Posts;
use App\Models\Menus;
use App\Models\Pages;
use DB;
use Illuminate\Http\Request;

class MenusController extends Controller
{
    public function index()
    {
        $menus = Menus::all()->paginate();

        return view('admin.menus')->with('menus', $menus);
    }

    public function create()
    {
        $pages = Pages::all();


        return view ('admin.create-menu')->with('pages', $pages);
    }

    public function store(Request $request)
    {
        $isCheckedNav = $request->has('navigation_menu');
        $isCheckedFoot = $request->has('footer_menu');

        $menu = new Menus();
        $menu->name = $request->menu_name;

        if($isCheckedNav) {
            $menu->navigation_menu = 1;
        }

        if($isCheckedFoot) {
            $menu->footer_menu = 1;
        }

        $menu->save();

        $lastId = DB::select("SHOW TABLE STATUS LIKE 'menus'");
        $menuid = $lastId[0]->Auto_increment;
        $menuid -= 1;

        foreach ($request->page_id as $pageid) {
            DB::table('menus_pages')
            ->insert([
                'pages_id' => $pageid,
                'menus_id' => $menuid]);
        }

        return redirect('/menus');
    }

    public function edit(Request $request)
    {
        $id = $request->input("id");
        $menu = Menus::find($id);

        $arraypages = [];

        foreach($menu->pages as $m) {
            $arraypages[] = $m->getOriginal('pivot_pages_id');
        }

        $pages = Pages::all();

        return view('admin.edit-menu')->with([
            'menu' => $menu,
            'pages' => $pages,
            'arraypages' => $arraypages
            ]);
    }

    public function update(Request $request)
    {
        $isCheckedNav = $request->has('navigation_menu');
        $isCheckedFoot = $request->has('footer_menu');

        $id = $request->input("id");
        $menu = Menus::find($id);

        $menu->update([
            'name' => $request->menu_name
                ]);

        if($isCheckedNav) {
            $menu->navigation_menu = 1;
        }

        if($isCheckedFoot) {
            $menu->footer_menu = 1;
        }
        $menu->save();

        DB::table('menus_pages')->where('menus_id', $id)->delete();

        foreach ($request->page_id as $pageid) {
            DB::table('menus_pages')->where(['menus_id' => $id])
            ->insert([
                'pages_id' => $pageid,
                'menus_id' => $id]);
    }

        return redirect('/menus')->with('message', 'Menu is successfully updated.');
    }

    public function destroy(Request $request)
    {
        $id = $request->input("id");
        $menu = Menus::find($id);

                if($menu != null) {
                    $menu->delete();
                    return redirect('/menus')->with('message', 'Menu is successfully deleted.');
                }
    }
}
