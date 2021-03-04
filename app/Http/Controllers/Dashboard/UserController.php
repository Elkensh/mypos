<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:users_read'])->only('index');
        $this->middleware(['permission:users_create'])->only('create');
        $this->middleware(['permission:users_update'])->only('edit');
        $this->middleware(['permission:users_delete'])->only('destroy');
    }

    public function index(Request $request)
    {
        ///////////// local search /////////

        /*if ($request->search)
        {
            $users = User::whereRoleIs('admin')
                ->where('first_name','like','%' . $request->search . '%')
                ->orWhere('last_name','like','%' . $request->search . '%')
                ->get();

        } else {
            $users = User::whereRoleIs('admin')->get();
        }
        return view('dashboard.users.index',compact('users'));
        */

        //////// Advansed search ///////////////


            $users = User::whereRoleIs('admin')
                ->where(function ($q) use($request){           ///// use mohema tosta5dam el $request in the function //
                    return $q->when($request->search , function($qq) use ($request){

                        return $qq->where('first_name','like','%' . $request->search . '%')
                            ->orWhere('last_name','like','%' . $request->search . '%');
                    });

                // latest() => btgip ely fey ala5er wt5lih fey alawel
                })->latest()->paginate(10);

        return view('dashboard.users.index',compact('users'));

    }


    public function create()
    {
        return view('dashboard.users.create');
    }


    public function store(Request $request)
    {
        /*try {*/
            $request->validate([
                'first_name' => 'required',
                'last_name'  => 'required',
                'email'      => 'required|unique:users',
                'password'   => 'required|confirmed',
                'image'      => 'image',
                'permissions' => 'required|min:1',
            ]);

            $request_data = $request->except(['password','password_confirmation','permissions','image']);
            $request_data['password'] = bcrypt($request->password);

            // local save image //
            /*if($request->image){
                $file_extension = $request->image->getClientOriginalExtension();
                $file_name = time() . '.' .$file_extension;
                $path = 'public/uploads/user_images';
                $request->image->move($path,$file_name);
                $request_data['image'] = $file_name;

            }*/

            // save image //
            if($request->image) {
                Image::make($request->image)->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(base_path('uploads/user_images/' . $request->image->hashName()));
                $request_data['image'] = $request->image->hashName();
            }//end if for image

            $user = User::create($request_data);
            $user->attachRole('admin');
            // mohem 3shan mytlash error add if //
            if($request->permissions) {
                $user->syncPermissions($request->permissions);
            }//in if for permission

            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('users.index');

        /*}catch (\Exception $e)
        {
            session()->flash('success', $e);
            return redirect()->route('users.index');
        }*/

    }//end store method


    public function edit(User $user)
    {
        return view('dashboard.users.edit',compact('user'));

    }//end of edit


    public function update(Request $request, User $user)
    {

            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => ['required',Rule::unique('users')->ignore($user->id),],
                'image' => 'image',
                'permissions' => 'required|min:1',
            ]);

            $request_data = $request->except('permissions','image');

        // save image //

        if($request->image) {

            if ($user->image != 'download.jfif') {

                Storage::disk('public_uploads')->delete('/user_images/' . $user->image);
            }//end if delete image

            Image::make($request->image)->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(base_path('uploads/user_images/' . $request->image->hashName()));
            $request_data['image'] = $request->image->hashName();

        }//end if for image

            $user->update($request_data);

            if ($request->permissions) {
                $user->syncPermissions($request->permissions);
            }
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('users.index');

    }//end of update


    public function destroy(User $user)
    {
        if ($user->image != 'download.jfif'){
            Storage::disk('public_uploads')->delete('/user_images/' . $user->image);
        }
        $user->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('users.index');

    }//end of destroy
}
