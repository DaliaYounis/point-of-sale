<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;


//Models
use App\Models\User;

//Request
use App\Http\Requests\UserRequest;
use App\Http\Requests\UpdateUserRequest;

use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    use ImageTrait;
    public  $models = ['users', 'categories', 'products', 'clients', 'orders'];
    public $maps = ['create', 'read', 'update', 'delete'];
    public function __construct()
    {
        $this->middleware(['permission:users_read'])->only('index');
        $this->middleware(['permission:users_create'])->only('create');
        $this->middleware(['permission:users_update'])->only('edit');
        $this->middleware(['permission:users_delete'])->only('destroy');

    }
    public function index(Request $request)
    {
        $users = User::whereRoleIs('admin')->where(function ($q) use ($request) {
            $q->when($request->search, function ($query) use ($request) {
                return $query->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%');
            });
        })->latest()->paginate(2);
        return view('dashboard.users.index', compact('users'));
    }

    public function create()
    {
        return view('dashboard.users.create', ['models' =>$this->models, 'maps'=>$this->maps]);
    }

    public function store(UserRequest $request)
    {
        $request_data = $request->except(['password', 'password_confirmation', 'permissions', 'image']);
        $request_data['password'] = \Hash::make($request->password);
        if ($request->image) {
            $this->saveImage($request,'users');
            $request_data['image'] = $request->image->hashName();
        }
        $user = User::create($request_data);
        $user->attachRole('admin');
        if ($request->permissions) {
            $user->syncPermissions($request->permissions);
        }
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.users.index');

    }

    public function edit(User $user)
    {
        return view('dashboard.users.edit', ['user'=>$user,'models' =>$this->models, 'maps'=>$this->maps]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $request_data = $request->except(['permissions', 'image']);
        if ($request->image) {
            if ($user->image != 'default.png') {
                //delete previous image
                \Storage::disk('public_uploads')->delete('/users/' . $user->image);
            }
            $this->saveImage($request,'users');
            $request_data['image'] = $request->image->hashName();

        }
        $user->update($request_data);
        $user->syncPermissions($request->permissions);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.users.index');
    }

    public function destroy(User $user)
    {
        if ($user->image != 'default.png') {
            \Storage::disk('public_uploads')->delete('/users/' . $user->image);
        }
        $user->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.users.index');

    }
}

