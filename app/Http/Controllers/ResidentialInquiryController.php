<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Exception;
use App\Models\Residentials;
use App\Models\ResidentialInquiry;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController as BaseController;

class ResidentialInquiryController extends BaseController
{
    public function store(Request $request)
    {
        //Using Try & Catch For Error Handling
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'client_name' => 'required|string|max:50',
                'client_number' => 'required|max:15',
                'residential_id' => 'required|exists:residentials,id',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $data = ResidentialInquiry::create($input);
            return $this->sendResponse([], 'Residential Inquiry created successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }

    public function residentialInquiry(Request $request)
    {
        try {
            $data = ResidentialInquiry::join('residentials', 'residentials.id', '=', 'residential_inquiries.residential_id')->join('type_of_properties', 'type_of_properties.id', '=', 'residentials.type_of_property_id')->select('residential_inquiries.id', 'client_name', 'client_number', 'residentials.name as residential_name', 'type_of_properties.no_bhk', 'residentials.square_yard', 'residentials.location')->where('status', 1)->orderBy('id', 'DESC')->paginate($request->itemsPerPage ?? 10);
            return $this->sendResponse($data, 'Residential Inquiry Data retrieved successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }
}
