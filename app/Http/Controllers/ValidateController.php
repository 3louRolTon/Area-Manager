<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\City;
use App\Models\Deputat;
use App\Models\District;
use App\Models\Spot;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ValidateController extends Controller
{
    use AuthenticatesUsers;

    public function show()
    {
        $data['areas'] = Area::getByUser();

        return View('validate.index', $data);
    }
}
