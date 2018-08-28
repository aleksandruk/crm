<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class StoreLoginController extends Controller
{

	public function __construct() 
    {
    	$this->middleware('guest:store', ['except' => ['logout']]);
    }

    public function showLoginForm() 
    {
    	return view('auth.store-login');
    }

    public function login(Request $request) 
    {
    	$this->validate($request, [
    		'pin' => 'required'
    	]);

    	if (Auth::guard('store')->attempt(['pin' => $request->pin, 'password' => $request->password], $request->remember)) {
    		return redirect()->intended(route('store.dashboard'));
    	}
    	return redirect()->back()->withInput($request->only('pin', 'remember'));
    }

    public function logout()
    {
    	Auth::guard('store')->logout();
    	return redirect('/');
    } 
}
