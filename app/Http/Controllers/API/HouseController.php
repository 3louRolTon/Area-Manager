<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\House as HouseResource;
use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HouseController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $houses = House::all();

        return $this->sendResponse(HouseResource::collection($houses), 'Houses retrieved successfully.');
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
            'house_number' => 'required',
            'street_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $house = House::create($input);

        return $this->sendResponse(new HouseResource($house), 'House created successfully.');
    }

    public function bind(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'spot_id' => 'required',
            'houses_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        foreach($input['houses_id'] as $id)
        {
            DB::table('houses')
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
            'houses_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        foreach($input['houses_id'] as $id)
        {
            DB::table('houses')
                ->where('id', $id)
                ->update(['spot_id' => null]);
        }

        return $this->sendResponse([], 'House created successfully.');

    }

    public function field($field, $id)
    {
        if($field == 'street_id' || $field == 'spot_id') {
            $house = House::where($field, $id)->get();
        } else abort(404);

        if (is_null($house)) {
            return $this->sendError('Houses not found.');
        }

        return $this->sendResponse(HouseResource::collection($house), 'House retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param House $house
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(House $house)
    {

        return $this->sendResponse(new HouseResource($house), 'House retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param House $house
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, House $house)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'house_number' => 'required',
            'street_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $house->update($request->all());

        return $this->sendResponse(new HouseResource($house), 'House updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param House $house
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(House $house)
    {
        return $this->sendResponse([json_encode($house)], 'House deleted successfully.');
        $house->delete();

        return $this->sendResponse([], 'House deleted successfully.');
    }
}
