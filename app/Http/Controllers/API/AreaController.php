<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Area as AreaResource;
use App\Models\Area;

class AreaController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $areas = Area::all();

        return $this->sendResponse(AreaResource::collection($areas), 'Areas retrieved successfully.');
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
            'area_name' => 'required|min:5'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $area = Area::create($input);

        return $this->sendResponse(new AreaResource($area), 'Area created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Area $area
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Area $area)
    {

        return $this->sendResponse(new AreaResource($area), 'Area retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Area $area
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Area $area)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'area_name' => 'required|min:5'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $area->update($request->all());

        return $this->sendResponse(new AreaResource($area), 'Area updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Area $area
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Area $area)
    {
        $area->delete();

        return $this->sendResponse([], 'Area deleted successfully.');
    }
}
