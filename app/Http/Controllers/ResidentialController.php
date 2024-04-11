<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Residentials;
use App\Models\ResidentialGallery;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController as BaseController;

class ResidentialController extends BaseController
{
    public function index(Request $request)
    {
        try {
            $data = Residentials::select('id', 'name', 'status')->where(function ($query) use ($request) {
                if ($request->search != null) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                }
            })->orderBy('id', 'DESC')->paginate($request->itemsPerPage ?? 10);
            return $this->sendResponse($data, 'Residentials Data retrieved successfully.');
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
                'name' => 'required|string|max:50',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
                'description' => 'nullable',
                'type_of_property_id' => 'required|exists:type_of_properties,id',
                'square_yard' => 'required|string|max:50',
                'status_id' => 'required|exists:statuses,id',
                'shop_square_feet' => 'nullable|max:50',
                'iframe' => 'nullable|string',
                'location' => 'required|string',
                'brochure' => 'nullable|mimes:pdf|max:30000',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $updateData = (['name' => $input['name'], 'description' => $input['description'], 'type_of_property_id' => $input['type_of_property_id'], 'square_yard' => $input['square_yard'], 'status_id' => $input['status_id'], 'shop_square_feet' => $input['shop_square_feet'], 'iframe' => $input['iframe'], 'location' => $input['location']]);
            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('images/residential'), $filename);
                $updateData['image'] = $filename;
            }
            if ($request->file('brochure')) {
                $file = $request->file('brochure');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('brochure/residentialBrochure'), $filename);
                $updateData['brochure'] = $filename;
            }
            // Insert or Update Residentials in residentials Table
            $data = Residentials::insert($updateData);
            return $this->sendResponse($data, 'Residentials created successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }

    public function show($id)
    {
        //Using Try & Catch For Error Handling
        try {
            $data = Residentials::where('id', $id)->select('id', 'name', 'image', 'description', 'type_of_property_id', 'square_yard', 'status_id', 'shop_square_feet', 'iframe', 'location', 'brochure', 'status')->first();
            if (is_null($data)) {
                return $this->sendError('Data not found.');
            }
            return $this->sendResponse($data, 'Residentials retrieved successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }

    public function update(Request $request, $id)
    {
        //Using Try & Catch For Error Handling
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required|string|max:50',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
                'description' => 'nullable',
                'type_of_property_id' => 'required|exists:type_of_properties,id',
                'square_yard' => 'required|string|max:50',
                'status_id' => 'required|exists:statuses,id',
                'shop_square_feet' => 'nullable|max:50',
                'iframe' => 'nullable|string',
                'location' => 'required|string',
                'brochure' => 'nullable|max:30000|mimes:pdf',
                'status' => 'required|in:0,1',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $updateData = (['name' => $input['name'], 'description' => $input['description'], 'type_of_property_id' => $input['type_of_property_id'], 'square_yard' => $input['square_yard'], 'status_id' => $input['status_id'], 'shop_square_feet' => $input['shop_square_feet'], 'iframe' => $input['iframe'], 'location' => $input['location'], 'status' => $input['status']]);
            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('images/residential'), $filename);
                $updateData['image'] = $filename;
            }
            if ($request->file('brochure')) {
                $file = $request->file('brochure');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('brochure/residentialBrochure'), $filename);
                $updateData['brochure'] = $filename;
            }
            // Insert or Update Residentials in residentials Table
            Residentials::where('id', $id)->update($updateData);
            return $this->sendResponse([], 'Residentials updated successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }

    public function showAllResidential()
    {
        //Using Try & Catch For Error Handling
        try {
            $data = Residentials::select('id', 'name', 'image', 'description', 'type_of_property_id', 'square_yard', 'status_id', 'shop_square_feet', 'iframe', 'location', 'brochure')->where('status', 1)->get();
            if (is_null($data)) {
                return $this->sendError('Data not found.');
            }
            return $this->sendResponse($data, 'All Residential retrieved successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }

    public function indexResidentialGallery(Request $request, $id)
    {
        try {
            $residentialGallery = ResidentialGallery::where('residential_id', $id)->select('id', 'data')->orderBy('id', 'DESC')->paginate($request->itemsPerPage ?? 10);
            return $this->sendResponse($residentialGallery, 'Residential Gallery Data retrieved successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }

    public function storeResidentialGallery(Request $request, $id)
    {
        //Using Try & Catch For Error Handling
        try {
            //return $request;
            $input = $request->all();
            $validator = Validator::make($input, [
                'files' => 'required',
                'files.*' => 'mimes:jpg,jpeg,png,bmp,mp4|max:20000'
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            foreach ($input['files'] as $data) {
                $extension = $data->getClientOriginalExtension();
                $picExtension = array("jpeg", "png", "jpg", "svg");
                $filename = rand(11111, 99999) . strtotime("now") . '.' . $data->getClientOriginalExtension();
                $data->move(public_path('images/residentialGallery'), $filename);
                ResidentialGallery::insert(
                    [
                        'residential_id' => $id,
                        'data' => $filename,
                        'is_pic' => in_array($extension, $picExtension) ? 1 : 0,
                    ]
                );
            }
            return $this->sendResponse([], 'Residential Gallery created successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }

    public function deleteResidentialGallery($id)
    {
        //Using Try & Catch For Error Handling
        try {
            $data = DB::table('residential_galleries')->where('id', $id)->first();
            $path = public_path() . "/images/residentialGallery/" . $data->data;
            unlink($path);
            DB::table('residential_galleries')->where('id', $id)->delete();
            return $this->sendResponse([], 'Residential Gallery deleted successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }

    public function showAllResidentialGallery()
    {
        //Using Try & Catch For Error Handling
        try {
            $data = ResidentialGallery::select('id', 'residential_id', 'data')->get();
            if (is_null($data)) {
                return $this->sendError('Data not found.');
            }
            return $this->sendResponse($data, 'All Residential Gallery retrieved successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }
}
