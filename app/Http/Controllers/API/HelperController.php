<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Helper as HelperResource;
use App\Models\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\TextUI\Help;

class HelperController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $helper = Helper::all();

        return $this->sendResponse(HelperResource::collection($helper), 'Helpers retrieved successfully.');
    }

    public function field($field, $id)
    {
        if($field == 'deputat_id') {
            $helper = Helper::where($field, $id)->get();
        } else abort(404);

        if (is_null($helper)) {
            return $this->sendError('Helper not found.');
        }

        return $this->sendResponse(HelperResource::collection($helper), 'Helper retrieved successfully.');
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
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $helper = Helper::create($input);

        return $this->sendResponse(new HelperResource($helper), 'Helper created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Helper $helper
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Helper $helper)
    {

        return $this->sendResponse(new HelperResource($helper), 'Helper retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Helper $helper
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Helper $helper)
    {
        $helper->update($request->all());

        return $this->sendResponse(new HelperResource($helper), 'Helper updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Helper $helper
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Helper $helper)
    {
        $helper->delete();

        return $this->sendResponse([], 'Helper deleted successfully.');
    }
}
