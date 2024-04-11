<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Exception;
use App\Models\ContactUs;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController as BaseController;

class ContactUsController extends BaseController
{
    public function store(Request $request)
    {
        //Using Try & Catch For Error Handling
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required|string|max:50',
                'email' => 'required|string|max:100',
                'message' => 'required|string',
                'private_message' => 'required|string',
                'phone_number' => 'required|string|max:15',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            // Insert or Update Service in services Table
            $data = ContactUs::create($input);
            return $this->sendResponse([], 'Contact Us created successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }

    public function show(Request $request)
    {
        try {
            $data = ContactUs::select('id', 'name', 'email', 'message', 'private_message', 'phone_number')->orderBy('id', 'DESC')->paginate($request->itemsPerPage ?? 10);
            if (is_null($data)) {
                return $this->sendError('Contact Us not found.');
            }
            return $this->sendResponse($data, 'Contact Us retrieved successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }
}
