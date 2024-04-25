<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Exception;
use App\Models\AboutUs;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController as BaseController;

class AboutUsController extends BaseController
{
    public function updateOrCreateAboutUs(Request $request)
    {
        //Using Try & Catch For Error Handling
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
                'title' => 'required|string|max:100',
                'description' => 'nullable',
                'hand_of_experience' => 'nullable|max:10|integer',
                'million_square_feet' => 'nullable|max:10|integer',
                'units' => 'nullable|max:10|integer',
                'residential_property' => 'nullable|max:10|integer',
                'commercial_property' => 'nullable|max:10|integer',
                'plots' => 'nullable|max:10|integer',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $updateData = (['title' => $input['title'], 'description' => $input['description'], 'hand_of_experience' => $input['hand_of_experience'], 'million_square_feet' => $input['million_square_feet'], 'units' => $input['units'], 'residential_property' => $input['residential_property'], 'commercial_property' => $input['commercial_property'], 'plots' => $input['plots']]);
            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('images/aboutUs'), $filename);
                $updateData['image'] = $filename;
            }
            // Insert or Update About Us in about_us Table
            $data = AboutUs::updateOrInsert(
                ['id' => 1],
                $updateData
            );
            return $this->sendResponse([], 'About Us created successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }

    public function showAboutUs()
    {
        //Using Try & Catch For Error Handling
        try {
            $data = AboutUs::select('id', 'title', 'image', 'description', 'hand_of_experience', 'million_square_feet', 'units', 'residential_property', 'residential_property', 'commercial_property', 'plots')->first();
            if (is_null($data)) {
                return $this->sendError('Data not found.');
            }
            return $this->sendResponse($data, 'About Us retrieved successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }
}
