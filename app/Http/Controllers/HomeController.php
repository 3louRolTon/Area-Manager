<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if(!Auth::check()) return Redirect::to('auth/login');
        if(Auth::user()->hasRole('super-admin|admin')) return Redirect::to('/admin');
        if(Auth::user()->hasRole('user')) return Redirect::to('/user');
        if(Auth::user()->hasRole('validate')) return Redirect::to('/validate');

    }
}
