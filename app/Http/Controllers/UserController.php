<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Posts;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use UploadTrait;

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }


    public function index()
    {
        $users = User::all()->paginate(10);

        return view('admin.users')->with('users', $users);
    }

    public function createIndex() {

        return view('admin.create-user');

    }

     public function create(Request $request)
    {
        // Form validation
        $request->validate([
            'name' => 'required',
            'description' => 'string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Get current user
        $user = new User();
        // Set user name
        $user->name = $request->input('name');
        $user->description = $request->input('description');
        $user->email = $request->input('email');
        $user->password = $request->input('password');

        // Check if a profile image has been uploaded
        if ($request->has('image')) {
            // Get image file
            $image = $request->file('image');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request->input('name')).'_'.time();
            // Define folder path
            $folder = '/uploads/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $user->image = $filePath;
        }
        // Persist user record to database
        $user->save();

        return redirect('/users');
    }

    public function edit(Request $request)
    {
        $id = $request->input("id");
        $user = User::find($id);

        return view('admin.edit-user')->with(['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);

        $data = $request->input();
        $user->name = $data['name'];
        $user->description = $data['description'];
        $user->email = $data['email'];
        $user->password = $data['password'];

        if ($request->has('image')) {
            // Get image file
            $image = $request->file('image');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request->input('title')).'_'.time();
            // Define folder path
            $folder = '/uploads/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $user->image = $filePath;
        }

        $user->save();

        return redirect()->back()->with('message', 'User successfully updated.');
    }

    public function destroy(Request $request)
    {
        $id = $request->input("id");
        $user = User::find($id);

        if ($user != null && $user->id != 1) {
            $user->delete();
            return back()->with('message', 'User succesfully deleted');
        } else {
            return back()->with('dangermessage', 'You can not delete main admin');
        }
    }

    public function show(User $user)
    {
        $posts = Posts::where("userid", "=", $user->id)
        ->orderBy('created_at', 'desc')
        ->paginate(6);

        return view('user')->with(['user' => $user, 'posts' => $posts]);
    }
}
