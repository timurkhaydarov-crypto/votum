<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
	public function index()
	{
		return view('index');
	}

	public function login()
	{
		return view('index');
	}

	public function register()
	{
		return view('index');
	}

	public function forgotPassword()
	{
		return view('index');
	}
}
