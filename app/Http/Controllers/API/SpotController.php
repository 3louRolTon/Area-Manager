<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Spot as SpotResource;
use App\Models\Spot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SpotController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $spots = Spot::all();

        return $this->sendResponse(SpotResource::collection($spots), 'Spots retrieved successfully.');
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
            'spot_name' => 'required',
            'information' => 'required',
            'address' => 'required',
            'district_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $spot = Spot::create($input);

        return $this->sendResponse(new SpotResource($spot), 'Spot created successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBind($spot_id)
    {

        if(!$spot_id){
            return $this->sendError('Validation Error.', $spot_id);
        }

        $data['city'] = DB::table('cities')
            ->where('cities.spot_id', "=", $spot_id)
            ->select('city_name', 'city_type', 'city_category')->get();

        $data['house'] = DB::table('cities')
            ->join('streets', 'streets.city_id', '=', 'cities.id')
            ->join('houses', 'houses.street_id', '=', 'streets.id')
            ->where('houses.spot_id', "=", $spot_id)
            ->select('city_name', 'city_type', 'city_category', 'street_name', 'street_type', 'house_number')->get();

        return $this->sendResponse($data , 'Spot created successfully.');
    }

    public function bind(Request $request)
    {
        //return $request;
        $input = $request->all();

        $validator = Validator::make($input, [
            'spots_id' => 'required',
            'deputat_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        foreach($input['spots_id'] as $id)
        {
            DB::table('spots')
                ->where('id', $id)
                ->update(['deputat_id' => $input['deputat_id']]);
        }

        return $this->sendResponse([], 'Spots bind successfully.');

    }

    public function unbind(Request $request)
    {
        //return $request;
        $input = $request->all();

        $validator = Validator::make($input, [
            'spots_id' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        foreach($input['spots_id'] as $id)
        {
            DB::table('spots')
                ->where('id', $id)
                ->update(['deputat_id' => null]);
        }

        return $this->sendResponse([], 'Spots unbind successfully.');

    }

    public function field($field, $id)
    {
        if($field == 'district_id' || $field == 'deputat_id') {
            $spot = Spot::where($field, $id)->get();
        } else abort(404);

        if (is_null($spot)) {
            return $this->sendError('Spots not found.');
        }

        return $this->sendResponse(SpotResource::collection($spot), 'Spot retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Spot $spot
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Spot $spot)
    {

        return $this->sendResponse(new SpotResource($spot), 'Spot retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Spot $spot
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Spot $spot)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'spot_name' => 'required',
            'information' => 'required',
            'address' => 'required',
            'district_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $spot->update($request->all());

        return $this->sendResponse(new SpotResource($spot), 'Spot updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Spot $spot
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Spot $spot)
    {
        $spot->delete();

        return $this->sendResponse([], 'Spot deleted successfully.');
    }
}
