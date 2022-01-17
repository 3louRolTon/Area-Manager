<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\District as DistrictResource;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DistrictController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $district = District::all();

        return $this->sendResponse(DistrictResource::collection($district), 'Districts retrieved successfully.');
    }

    public function field($field, $id)
    {
        if($field == 'area_id') {
            $district = District::where($field, $id)->get();
        } else abort(404);

        if (is_null($district)) {
            return $this->sendError('Districts not found.');
        }

        return $this->sendResponse(DistrictResource::collection($district), 'District retrieved successfully.');
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
            'district_name' => 'required',
            'area_id' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $district = District::create($input);

        return $this->sendResponse(new DistrictResource($district), 'District created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param District $district
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(District $district)
    {

        return $this->sendResponse(new DistrictResource($district), 'District retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param District $district
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, District $district)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'district_name' => 'required',
            'area_id' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $district->update($request->all());

        return $this->sendResponse(new DistrictResource($district), 'District updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param District $district
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(District $district)
    {
        $district->delete();

        return $this->sendResponse([], 'District deleted successfully.');
    }
}
