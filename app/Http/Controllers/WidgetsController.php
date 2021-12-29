<?php

namespace App\Http\Controllers;

use App\Models\Widgets;
use App\Models\Categories;
use App\Models\Media;
use Illuminate\Http\Request;
use App\Traits\UploadTrait;
use Illuminate\Support\Str;

class WidgetsController extends Controller
{
    use UploadTrait;

    public function index()
    {
        $widgets = Widgets::all()->paginate(10);

        return view('admin.widgets')->with('widgets', $widgets);
    }

    public function create()
    {
        $types = [
            0 => 'slider',
            1 => 'starrater',
            2 => 'catagolizer'
            ];

        $media = Media::all();
        $categories = Categories::all();

        return view('admin.create-widget')->with([
            'types' => $types,
            'categories' => $categories,
            'media' => $media
            ]);
    }

    public function store(Request $request)
    {

        $widget = new Widgets();

        $this->storeWidgetData($request, $widget);

        return redirect('/widgets')->with('message', 'Widget successfully updated.');
    }

    public function storeWidgetData(Request $request, $widget) {

        $data = $request->input();
        $widget->name = $data['name'];
        $widget->description = $data['description'];
        $widget->type = $data['type'];

        $widgetname = '';

        if($widget->type == 0) {
            $widgetname = 'slider';
        } elseif($widget->type == 1) {
            $widgetname = 'starrater';
        }elseif($widget->type == 2) {
            $widgetname = 'catagolizer';
        }

        for($i = 1; $i < 7; $i++) {
            $title = '';
            if($data[$widgetname . '_title_' . $i] != '') {
                $title = $data[$widgetname . '_title_' . $i];
            }
            $description = '';
            if($data[$widgetname . '_title_' . $i] != '') {
                $description = $data[$widgetname . '_description_' . $i];
            }
            $image = '';
            if($data[$widgetname . '_title_' . $i] != '') {
                 $image = $data[$widgetname . '_image_' . $i];
            }

            $array[$widgetname . '_title_' . $i] = $title;
            $array[$widgetname . '_description_' . $i] = $description;
            $array[$widgetname . '_image_' . $i] = $image;
        }

        $serialized_array = serialize($array);
        $widget->details = $serialized_array;

        $widget->save();
    }

    public function edit(Request $request)
    {
        $id = $request->input("id");
        $widget = Widgets::find($id);
        $media = Media::all();

        $types = [
            0 => 'slider',
            1 => 'starrater',
            2 => 'catagolizer'
            ];

        $categories = Categories::all();

        $details = unserialize($widget->details);
        //dd($details);

        return view('admin.edit-widget')->with([
            'widget' => $widget,
            'types' => $types,
            'details' => $details,
            'categories' => $categories,
            'media' => $media
            ]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $widget = Widgets::find($id);
        $this->storeWidgetData($request, $widget);

        return redirect('/widgets')->with('message', 'Widget successfully updated.');
    }

    public function destroy(Request $request)
    {
        $id = $request->input("id");
        $widget = Widgets::find($id);

        if($widget) {
            $widget->delete();
        }
        return redirect('/widgets')->with('message', 'Widget successfully deleted.');
    }
}
