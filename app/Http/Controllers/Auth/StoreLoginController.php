<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Storekeeper;

class StoreLoginController extends Controller
{

	public function __construct() 
    {
    	$this->middleware('guest:store', ['except' => ['logout']]);
    }

    public function showLoginForm() 
    {
        $users = Storekeeper::all();
    	return view('auth.store-login', compact('users'));
    }

    // public function login(Request $request) 
    // {
    // 	$this->validate($request, [
    // 		'email' => 'required|email',
    //         'password' => 'required|min:6'
    // 	]);

    // 	if (Auth::guard('store')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
    // 		return redirect()->intended(route('store.dashboard'));
    // 	}
    // 	return redirect()->back()->withInput($request->only('email', 'remember'));
    // }

    public function login(Request $request)
    {
    	$user = Storekeeper::findByPin($request->pin);
		$userId = $user->id;
		$loginUser = Auth::guard('store')->loginUsingId($userId, true);
		return redirect()->intended(route('store.dashboard'));
    }

    public function logout()
    {
    	Auth::guard('store')->logout();
    	return redirect('/store/login');
    } 
}
