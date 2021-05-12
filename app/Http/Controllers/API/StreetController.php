<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Street as StreetResource;
use App\Models\Street;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StreetController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $streets = Street::all();

        return $this->sendResponse(StreetResource::collection($streets), 'Streets retrieved successfully.');
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
            'street_name' => 'required',
            'street_type' => 'required',
            'city_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $street = Street::create($input);

        return $this->sendResponse(new StreetResource($street), 'Street created successfully.');
    }

    public function field($field, $id)
    {
        if($field == 'city_id') {
            $street = Street::where($field, $id)->get();
        } else abort(404);

        if (is_null($street)) {
            return $this->sendError('Spots not found.');
        }

        return $this->sendResponse(StreetResource::collection($street), 'Spot retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Street $street
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Street $street)
    {

        return $this->sendResponse(new StreetResource($street), 'Street retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Street $street
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Street $street)
    {
        $street->update($request->all());

        return $this->sendResponse(new StreetResource($street), 'Street updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Street $street
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Street $street)
    {
        $street->delete();

        return $this->sendResponse([], 'Street deleted successfully.');
    }
}
