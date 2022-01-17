<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\City as CityResource;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CityController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cities = City::all();

        return $this->sendResponse(CityResource::collection($cities), 'Cities retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'city_name' => 'required',
            'district_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $city = City::create($input);

        return $this->sendResponse(new CityResource($city), 'City created successfully.');
    }

    public function bind(Request $request)
    {
        //return $request;
        $input = $request->all();

        $validator = Validator::make($input, [
            'spot_id' => 'required',
            'cities_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        foreach($input['cities_id'] as $id)
        {
            DB::table('cities')
                ->where('id', $id)
                ->update(['spot_id' => $input['spot_id']]);
        }

        return $this->sendResponse([], 'House created successfully.');

    }

    public function unbind(Request $request)
    {
        //return $request;
        $input = $request->all();

        $validator = Validator::make($input, [
            'cities_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        foreach($input['cities_id'] as $id)
        {
            DB::table('cities')
                ->where('id', $id)
                ->update(['spot_id' => null]);
        }

        return $this->sendResponse([], 'House created successfully.');

    }

    public function field($field, $id)
    {
        if($field == 'district_id' || $field == 'spot_id') {
            $city = City::where($field, $id)->get();
        } else abort(404);

        if (is_null($city)) {
            return $this->sendError('Cities not found.');
        }

        return $this->sendResponse(CityResource::collection($city), 'City retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param City $city
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(City $city)
    {

        return $this->sendResponse(new CityResource($city), 'City retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param City $city
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, City $city)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'city_name' => 'required',
            'district_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $city->update($request->all());

        return $this->sendResponse(new CityResource($city), 'City updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param City $cities
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(City $cities)
    {
        $cities->delete();

        return $this->sendResponse([], 'City deleted successfully.');
    }
}
