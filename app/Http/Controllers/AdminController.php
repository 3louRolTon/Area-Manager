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

        $select_areas = [4, 3, 1, 5, 7, 2, 6];

        if($user->hasRole('super-admin')) {
            $areas = [];
            foreach ($select_areas as $area_id){
                $area = (Area::where('id', $area_id)->get())[0];
                $districts = [];
                foreach (District::where('area_id', $area->id)->get() as $district){
                    $cities = [];
                    foreach (City::where('district_id', $district->id)->get() as $city) {
                        $streets = [];
                        foreach (Street::where('city_id', $city->id)->get() as $street){
                            $houses = [];
                            foreach (House::where('street_id', $street->id)->whereNotNull('spot_id')->get() as $house){
                                if($house->house_number == "") continue;

                                $houses[] = [
                                    "houseNumber" => $house->house_number,
                                    "spotId" => strval($house->spot_id)
                                ];
                            }
                            if(count($houses) > 0){
                                $streets[] = [
                                    'streetName' => $street->street_name,
                                    'streetType' => $street->street_type,
                                    'houseList' => $houses
                                ];
                            }
                        }
                        if(count($streets) > 0){
                            $cities[] = [
                                'cityName' => $city->city_name,
                                'categoryName' => $city->city_type,
                                'cityCategory' =>($city->city_category != "" ? $city->city_category : null),
                                'citySpotId' => ($city->spot_id != "" ? strval($city->spot_id) : null),
                                'streetList' => $streets
                            ];
                        } else if($city->spot_id) {
                            $cities[] = [
                                'cityName' => $city->city_name,
                                'categoryName' => $city->city_type,
                                'cityCategory' =>  ($city->city_category != "" ? $city->city_category : null),
                                'citySpotId' => ($city->spot_id != "" ? strval($city->spot_id) : null),
                                'streetList' => null
                            ];
                        }
                    }
                    if(count($cities) > 0){
                        $districts[] = [
                            'districtName' => $district->district_name,
                            'cityList' => $cities
                        ];
                    }
                }
                if(count($districts) > 0){
                    $areas[] = [
                        'regionName' => $area->area_name,
                        'districtList' => $districts
                    ];
                }
            }
            $jsonFile = time() . '_file.json';
            Storage::put('upload/json/'.$jsonFile, json_encode(['regionList' => $areas], JSON_UNESCAPED_UNICODE));
            return Storage::download('upload/json/'.$jsonFile);
        }
    }
}
