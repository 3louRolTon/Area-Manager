<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\District;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    use AuthenticatesUsers;

    public function index()
    {
        return view('admin.index');
    }

    public function showRegisterForm()
    {
        $user = Auth::user();
        if($user->hasRole('super-admin'))
        {
            $data['areas'] = Area::all();
        }

        if($user->hasRole('admin'))
        {
            $data['areas'] = Area::where('id', $user->area_id)->get();
            $data['districts'] = District::where('area_id', $user->area_id)->get();
        }
        //return $data;
        return view('admin.register', $data);
    }

    public function showUpdateForm()
    {
        $data['users'] = User::getByUser();
        $user = Auth::user();
        if($user->hasRole('super-admin'))
        {
            $data['areas'] = Area::all();
        }

        if($user->hasRole('admin'))
        {
            $data['areas'] = Area::where('id', $user->area_id)->get();
            $data['districts'] = District::where('area_id', $user->area_id)->get();
        }

        return view('admin.update', $data);
    }

    public function get()
    {
        $user = Auth::user();
        if($user->hasRole('super-admin'))
        {
            $data['users'] = User::all();
        }
        else $data['users'] = User::where('area_id', $user->area_id)->get();

        //return $data;
        return view('admin.update', $data);
    }
}
