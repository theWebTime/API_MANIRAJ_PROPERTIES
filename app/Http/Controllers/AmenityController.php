<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Exception;
use App\Models\Amenity;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController as BaseController;

class AmenityController extends BaseController
{
    public function index(Request $request)
    {
        try {
            $data = Amenity::select('id', 'name', 'status')->where(function ($query) use ($request) {
                if ($request->search != null) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                }
            })->orderBy('id', 'DESC')->paginate($request->itemsPerPage ?? 10);
            return $this->sendResponse($data, 'Amenity Data retrieved successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }

    public function store(Request $request)
    {
        //Using Try & Catch For Error Handling
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required|max:80',
                'description' => 'nullable',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $updateData = (['name' => $input['name'], 'description' => $input['description']]);
            // Insert or Update Amenity in amenities Table
            $data = Amenity::insert($updateData);
            return $this->sendResponse($data, 'Amenity created successfully.');
        } catch (Exception $e) {
            return $e;
            return $this->sendError('something went wrong!', $e);
        }
    }

    public function show(Request $request)
    {
        //Using Try & Catch For Error Handling
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'amenity_show' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $data = Amenity::where('id', $request->input('amenity_show'))->select('id', 'name', 'description', 'status')->first();
            if (is_null($data)) {
                return $this->sendError('Data not found.');
            }
            return $this->sendResponse($data, 'Amenity retrieved successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }

    public function update(Request $request)
    {
        //Using Try & Catch For Error Handling
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required|max:80',
                'description' => 'nullable',
                'status' => 'required|in:0,1',
                'amenity_update' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $updateData = (['name' => $input['name'], 'description' => $input['description'], 'status' => $input['status']]);
            // Insert or Update Amenity in amenities Table
            Amenity::where('id', $request->input('amenity_update'))->update($updateData);
            return $this->sendResponse([], 'Amenity updated successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }

    public function showAllAmenity()
    {
        //Using Try & Catch For Error Handling
        try {
            $data = Amenity::select('id', 'name', 'description')->where('status', 1)->get();
            return $this->sendResponse($data, 'All Amenity retrieved successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }
}