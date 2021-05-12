<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Deputat as DeputatResource;
use App\Models\Deputat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeputatController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $deputats = Deputat::all();

        return $this->sendResponse(DeputatResource::collection($deputats), 'Deputats retrieved successfully.');
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
            'name1' => 'required',
            'name2' => 'required',
            'name3' => 'required',
            'district' => 'required',
            'biography' => 'required',
            'district_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $deputat = Deputat::create($input);

        return $this->sendResponse(new DeputatResource($deputat), 'Deputat created successfully.');
    }

    public function field($field, $id)
    {
        if($field == 'district_id') {
            $deputat = Deputat::where($field, $id)->get();
        } else abort(404);

        if (is_null($deputat)) {
            return $this->sendError('Deputats not found.');
        }

        return $this->sendResponse(DeputatResource::collection($deputat), 'Deputat retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Deputat $deputat
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Deputat $deputat)
    {

        return $this->sendResponse(new DeputatResource($deputat), 'Deputat retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Deputat $deputat
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Deputat $deputat)
    {
        $deputat->update($request->all());

        return $this->sendResponse(new DeputatResource($deputat), 'Deputat updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Deputat $deputat
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Deputat $deputat)
    {
        $deputat->delete();

        return $this->sendResponse([], 'Deputat deleted successfully.');
    }
}
