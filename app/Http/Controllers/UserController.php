<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function notify()
    {
        return view('user.notify');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }
    public function changepass()
    {
        $user = Auth::user();
        return view('user.changepass', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $this->validate(request(), [
            'name' => 'required',
            'tel' => 'required',
        ]);

        $user->name = request('name');
        $user->tel = request('tel');
        $user->save();
        return back()->withSuccess('User Updated with Success');
    }
    public function emailchange(Request $request)
    {
        $user = Auth::user();
        $this->validate(request(), [
            'email' => 'required|email',
        ]);

        $user->email = request('email');
        $user->save();
        return back()->withSuccess('User Updated with Success');
    }


    public function savepass(Request $request)
    {
        $user = Auth::user();
        $this->validate(request(), [
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',

        ]);

        $user->password = bcrypt(request('password'));
        $user->save();
        return back()->withSuccess('User Updated with Success');
    }

    public function getAuthUser()
    {
        return Auth::user();
    }

    public function updateAuthUser(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . Auth::id()
        ]);

        $user = User::find(Auth::id());

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return $user;
    }

    public function updateAuthUserPassword(Request $request)
    {
        $this->validate($request, [
            'current' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = User::find(Auth::id());

        if (!Hash::check($request->current, $user->password)) {
            return response()->json(['errors' => ['current' => ['Current password does not match']]], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return $user;
    }
}
