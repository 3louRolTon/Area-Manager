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

class UserController extends Controller
{
    use AuthenticatesUsers;

    public function showBindForm()
    {

        $data['areas'] = Area::getByUser();
        $data['districts'] = District::getByUser();
        $data['cities'] = City::getByUser();
        $data['spots'] = Spot::getByUser();

        return View('user.index', $data);
    }
    public function showUnbindForm()
    {
        $data['areas'] = Area::getByUser();
        $data['districts'] = District::getByUser();
        $data['spots'] = Spot::getByUser();

        return View('user.unbind', $data);
    }

    public function showSpotBindForm()
    {
        $data['areas'] = Area::getByUser();
        $data['districts'] = District::getByUser();
        $data['deputats'] = Deputat::getByUser();
        $data['spots'] = Spot::getByUser();

        return View('user.bindSpot', $data);
    }
    public function showSpotUnbindForm()
    {
        $data['areas'] = Area::getByUser();
        $data['districts'] = District::getByUser();
        $data['deputats'] = Deputat::getByUser();

        return View('user.unbindSpot', $data);
    }

    public function showAreaCreateForm()
    {
        return view('user.create.area');
    }
    public function showDistrictCreateForm()
    {
        $data['areas'] = Area::getByUser();

        return view('user.create.district', $data);
    }
    public function showCityCreateForm()
    {
        $data['areas'] = Area::getByUser();
        $data['districts'] = District::getByUser();

        return view('user.create.city', $data);
    }
    public function showStreetCreateForm()
    {
        $data['areas'] = Area::getByUser();
        $data['districts'] = District::getByUser();
        $data['cities'] = City::getByUser();

        return view('user.create.street', $data);
    }
    public function showHouseCreateForm()
    {
        $data['areas'] = Area::getByUser();
        $data['districts'] = District::getByUser();
        $data['cities'] = City::getByUser();

        return view('user.create.house', $data);
    }
    public function showSpotCreateForm()
    {
        $data['areas'] = Area::getByUser();
        $data['districts'] = District::getByUser();

        return view('user.create.spot', $data);
    }

    public function showDeputatCreateForm()
    {
        $data['areas'] = Area::getByUser();
        $data['districts'] = District::getByUser();

        return view('user.create.deputat', $data);
    }

    public function showHelperCreateForm()
    {
        $data['areas'] = Area::getByUser();
        $data['districts'] = District::getByUser();
        $data['deputats'] = Deputat::getByUser();

        return view('user.create.helper', $data);
    }

    public function showAreaUpdateForm()
    {
        $data['areas'] = Area::getByUser();

        return view('user.update.area', $data);
    }
    public function showDistrictUpdateForm()
    {
        $data['areas'] = Area::getByUser();
        $data['districts'] = District::getByUser();

        return view('user.update.district', $data);
    }
    public function showCityUpdateForm()
    {
        $data['areas'] = Area::getByUser();
        $data['districts'] = District::getByUser();
        $data['cities'] = City::getByUser();

        return view('user.update.city', $data);
    }
    public function showStreetUpdateForm()
    {
        $data['areas'] = Area::getByUser();
        $data['districts'] = District::getByUser();
        $data['cities'] = City::getByUser();

        return view('user.update.street', $data);
    }
    public function showHouseUpdateForm()
    {
        $data['areas'] = Area::getByUser();
        $data['districts'] = District::getByUser();
        $data['cities'] = City::getByUser();

        return view('user.update.house', $data);
    }
    public function showSpotUpdateForm()
    {
        $data['areas'] = Area::getByUser();
        $data['districts'] = District::getByUser();
        $data['spots'] = Spot::getByUser();

        return view('user.update.spot', $data);
    }
    public function showDeputatUpdateForm()
    {
        $data['areas'] = Area::getByUser();
        $data['districts'] = District::getByUser();
        $data['deputats'] = Deputat::getByUser();

        return view('user.update.deputat', $data);
    }

    public function showHelperUpdateForm()
    {
        $data['areas'] = Area::getByUser();
        $data['districts'] = District::getByUser();
        $data['deputats'] = Deputat::getByUser();

        return view('user.update.helper', $data);
    }
}
