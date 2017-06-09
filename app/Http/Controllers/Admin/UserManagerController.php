<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserManagerController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::all();
        return view('admin.user.index', ['users' => $users]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('admin.user.add');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function postAdd(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'username' => 'required|unique:users|max:30|min:4',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6'
        ];

        //validate
        $this->validate($request, $rules);

        //now add new user
        $user = new User;

        $user->name = ucfirst($request->name);
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->admin = true;
        $user->superadmin = false;
        $user->status = true;
        $user->save();

        return redirect()->route('userManager')
            ->withErrors(['success' => 'User Successfully Added']);


    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', ['user' => $user]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function patchEdit(Request $request, $id)
    {
        $rules = [
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6'
        ];

        //validate
        $this->validate($request, $rules);

        $user = User::findOrFail($id);
        $user->password =  bcrypt($request->password);
        $user->save();

        return redirect()->route('userManager')
            ->withErrors( ['success' => 'Password Changed']);

    }

    /**
     * @param $id
     * @return mixed
     */
    public function changeStatus($id)
    {
        $user = User::findOrFail($id);

        //disable superuser from deactivate
        if ($user->superadmin == true) {
            return redirect()->back()
                ->withErrors(['error' => 'You cannot deactivate superadmin account']);
        }
        $user->status = !($user->status);
        $user->save();

        return redirect()->route('userManager')
            ->withErrors(['success' => 'User Status Changed']);

    }

}
