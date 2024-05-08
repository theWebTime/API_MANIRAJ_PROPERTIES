<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Exception;
use App\Models\Plot;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController as BaseController;

class PlotController extends BaseController
{
    public function index(Request $request)
    {
        try {
            $data = Plot::select('id', 'location', 'status')->where(function ($query) use ($request) {
                if ($request->search != null) {
                    $query->where('location', 'like', '%' . $request->search . '%');
                }
            })->orderBy('id', 'DESC')->paginate($request->itemsPerPage ?? 10);
            return $this->sendResponse($data, 'Plot Data retrieved successfully.');
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
                'square_yard' => 'required|string|max:50',
                'status_id' => 'required|exists:statuses,id',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $updateData = (['iframe' => $input['iframe'], 'location' => $input['location'], 'square_yard' => $input['square_yard'], 'status_id' => $input['status_id']]);
            // Insert or Update Plot in plots Table
            $data = Plot::insert($updateData);
            return $this->sendResponse($data, 'Plot created successfully.');
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
                'plot_show' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $data = Plot::where('id', $request->input('plot_show'))->select('id', 'iframe', 'location', 'square_yard', 'status_id', 'status')->first();
            if (is_null($data)) {
                return $this->sendError('Data not found.');
            }
            return $this->sendResponse($data, 'Plot retrieved successfully.');
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
                'square_yard' => 'required|string|max:50',
                'status_id' => 'required|exists:statuses,id',
                'status' => 'required|in:0,1',
                'plot_update' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $updateData = (['iframe' => $input['iframe'], 'location' => $input['location'], 'square_yard' => $input['square_yard'], 'status_id' => $input['status_id'], 'status' => $input['status']]);
            // Insert or Update Plot in plots Table
            Plot::where('id', $request->input('plot_update'))->update($updateData);
            return $this->sendResponse([], 'Plot updated successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }

    public function showAllPlot()
    {
        //Using Try & Catch For Error Handling
        try {
            $data = Plot::join('statuses', 'statuses.id', '=', 'plots.status_id')->select('plots.id', 'iframe', 'location', 'square_yard', 'statuses.name as status_name')->where('status', 1)->get();
            if (is_null($data)) {
                return $this->sendError('Data not found.');
            }
            return $this->sendResponse($data, 'All Plot retrieved successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }
}
