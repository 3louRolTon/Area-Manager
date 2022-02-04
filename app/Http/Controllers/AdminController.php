<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\District;
use App\Models\City;
use App\Models\Street;
use App\Models\House;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            $data['roles'] = [
                'admin',
                'user',
                'validate'
            ];
            $data['areas'] = Area::all();
        }

        if($user->hasRole('admin'))
        {
            $data['roles'] = [
                'admin',
                'user'
            ];
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

    public function DownloadJson()
    {
        $user = Auth::user();
        $json = [];
        if($user->hasRole('super-admin')) {
            $areas = [];
            foreach (Area::all() as $area){
                $districts = [];
                foreach (District::where('area_id', $area->id)->get() as $district){
                    $cities = [];
                    foreach (City::where('district_id', $district->id)->get() as $city) {
                        $streets = [];
                        foreach (Street::where('city_id', $city->id)->get() as $street){
                            $houses = House::where('street_id', $street->id)->whereNotNull('spot_id')->select('house_number', 'information', 'spot_id')->get();
                            if(count($houses) > 0){
                                $streets[] = [
                                    'name' => $street->street_name,
                                    'type' => $street->street_type,
                                    'houses' => $houses
                                ];
                            }
                        }
                        if(count($streets) > 0){
                            $cities[] = [
                                'name' => $city->city_name,
                                'type' => $city->city_type,
                                'category' => $city->city_category,
                                'spot_id' => $city->spot_id,
                                'streets' => $streets
                            ];
                        } else if($city->spot_id) {
                            $cities[] = [
                                'name' => $city->city_name,
                                'type' => $city->city_type,
                                'category' => $city->city_category,
                                'spot_id' => $city->spot_id,
                                'streets' => null
                            ];
                        }
                    }
                    if(count($cities) > 0){
                        $districts[] = [
                            'name' => $district->district_name,
                            'cities' => $cities
                        ];
                    }
                }
                if(count($districts) > 0){
                    $areas[] = [
                        'name' => $area->area_name,
                        'districts' => $districts
                    ];
                }
            }
            $jsonFile = time() . '_file.json';
            Storage::put('upload/json/'.$jsonFile, json_encode($areas, JSON_UNESCAPED_UNICODE));
            return Storage::download('upload/json/'.$jsonFile);
        }
    }
}
