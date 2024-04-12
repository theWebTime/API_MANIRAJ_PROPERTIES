<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Exception;
use App\Models\Commercial;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController as BaseController;

class CommercialController extends BaseController
{
    public function index(Request $request)
    {
        try {
            $data = Commercial::join('commercial_types', 'commercial_types.id', '=', 'commercials.commercial_type_id')->select('commercials.id', 'commercial_types.type', 'commercials.location', 'commercials.status')->where(function ($query) use ($request) {
                if ($request->search != null) {
                    $query->where('commercial_types.type', 'like', '%' . $request->search . '%');
                }
            })->orderBy('id', 'DESC')->paginate($request->itemsPerPage ?? 10);
            return $this->sendResponse($data, 'Commercial Data retrieved successfully.');
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
                'iframe' => 'nullable|string',
                'location' => 'required|string',
                'square_feet' => 'required|string|max:50',
                'status_id' => 'required|exists:statuses,id',
                'commercial_type_id' => 'required|exists:commercial_types,id',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $updateData = (['iframe' => $input['iframe'], 'location' => $input['location'], 'square_feet' => $input['square_feet'], 'status_id' => $input['status_id'], 'commercial_type_id' => $input['commercial_type_id']]);
            // Insert or Update Commercial in commercials Table
            $data = Commercial::insert($updateData);
            return $this->sendResponse($data, 'Commercial created successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }

    public function show(Request $request)
    {
        //Using Try & Catch For Error Handling
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'commercial_show' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $data = Commercial::where('commercials.id', $request->input('commercial_show'))->join('commercial_types', 'commercial_types.id', '=', 'commercials.commercial_type_id')->select('commercials.id', 'commercial_types.type', 'commercials.iframe', 'commercials.location', 'commercials.square_feet', 'commercials.status_id')->first();
            if (is_null($data)) {
                return $this->sendError('Data not found.');
            }
            return $this->sendResponse($data, 'Commercial retrieved successfully.');
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
                'iframe' => 'nullable|string',
                'location' => 'required|string',
                'square_feet' => 'required|string|max:50',
                'status_id' => 'required|exists:statuses,id',
                'commercial_type_id' => 'required|exists:commercial_types,id',
                'commercial_update' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $updateData = (['iframe' => $input['iframe'], 'location' => $input['location'], 'square_feet' => $input['square_feet'], 'status_id' => $input['status_id'], 'commercial_type_id' => $input['commercial_type_id']]);
            // Insert or Update Commercial in commercials Table
            Commercial::where('id', $request->input('commercial_update'))->update($updateData);
            return $this->sendResponse([], 'Commercial updated successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }

    public function showAllCommercial()
    {
        //Using Try & Catch For Error Handling
        try {
            $data = Commercial::join('commercial_types', 'commercial_types.id', '=', 'commercials.commercial_type_id')->select('commercials.id', 'commercial_types.type', 'commercials.iframe', 'commercials.location', 'commercials.square_feet', 'commercials.status_id')->where('status', 1)->get();
            return $this->sendResponse($data, 'All Commercial retrieved successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }
}
