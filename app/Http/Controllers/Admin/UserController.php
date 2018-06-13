<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginAdminRquest;
use Auth;
use Session;
use App\User;
use DB;
use Hash;

class UserController extends Controller
{

    public function index()
    {
        $breadcrumbs = array('user-list', null);
        $users = DB::table('users')->paginate(10);
        return view ('admin.user.index')->with(compact('users','breadcrumbs'));
    }

    public function formUser()
    {
        $breadcrumbs = array('user-add', null);
        return view('admin.user.form-user')->with(compact('breadcrumbs'));
    }

    public function editUser($id)
    {
        $user = User::find($id);
        $breadcrumbs = array('user-edit', $user);
        return view('admin.user.edit-user')->with(compact('user','breadcrumbs'));
    }

    public function storeUser($id, Request $request)
    {
        $users = User::find($id);

        $users->name     = $request->get('name');
        $users->username = $request->get('username');
        $users->address  = $request->get('address');
        $users->phone    = $request->get('phone');
        $users->birthday = $request->get('birthday');
        $users->admin    = $request->get('admin');

        if ( !empty($request->get('password')) )
            $users->password = Hash::make($request->get('password'));

        $users->save();
        return redirect('/admin/user');
    }

    public function delUser($id)
    {
        $users = User::find($id);
        $users->delete();
        return redirect('/admin/user');
    }

    public function addUser(LoginAdminRquest $request)
    {
        $admin  = $request->get('admin') == 'Admin' ? 1 : 0;
        $data   = array(
            'username'  => $request->get('username'),
            'name'      => $request->get('name'),
            'email'     => $request->get('email'),
            'password'  => bcrypt($request->get('password')),
            'phone'     => $request->get('phone'),
            'admin'     => $request->get('admin'),
            'address'   => $request->get('address'),
            'birthday'  => date( 'Y-m-d', strtotime($request->get('birthday')) ),
        );

        User::create($data);
        return redirect('/admin/user');
    }

    public function login()
    {
    	return view('admin.user.login');
    }

    public function loginPost(Request $request)
    {
    	$email 		= $request->get('email');
    	$password 	= $request->get('password');
        if(Auth::attempt(['email' => $email, 'password' => $password, 'admin' => 1]) ){
            return redirect('/admin/dashboard');
        } else{
            return redirect('/admin/login');
        }
    }

    public function logOut()
    {
        Auth::logout();
        return redirect('/admin/login');
    }
}
