<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\UploadTrait;

class MediaController extends Controller
{
    use UploadTrait;

    public function index()
    {
        $media = Media::all()->paginate();

        return view('admin.media')->with('media', $media);
    }

    public function create()
    {

        return view ('admin.create-media');
    }

    public function store(Request $request)
    {

        $data = $request->input();
        $image = new Media();
        $image->title = $data['title'];
        $image->alt = $data['alt'];

        if ($request->has('image')) {

            $img = $request->file('image');
            $name = Str::slug($request->input('title')).'_'.time();
            $folder = '/uploads/images/';
            $filePath = $folder . $name. '.' . $img->getClientOriginalExtension();
            $this->uploadOne($img, $folder, 'public', $name);
            $image->url = '/storage/app/public' .$filePath;
        }

        $image->save();

        return redirect('/media')->with('message', 'Image successfully uploaded.');
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
