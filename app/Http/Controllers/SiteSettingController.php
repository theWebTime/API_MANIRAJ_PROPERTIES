<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Exception;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController as BaseController;

class SiteSettingController extends BaseController
{
    public function updateOrCreateSiteSetting(Request $request)
    {
        //Using Try & Catch For Error Handling
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
                'email1' => 'required|max:100',
                'email2' => 'nullable|max:100',
                'phone_number1' => 'required|max:10',
                'phone_number2' => 'nullable|max:10',
                'address' => 'required|string',
                'iframe' => 'nullable|string',
                'video_link' => 'nullable|url',
                'facebook_link' => 'nullable|max:200|url',
                'instagram_link' => 'nullable|max:200|url',
                'youtube_link' => 'nullable|max:200|url',
                'whatsapp_number' => 'nullable|max:10',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $updateData = (['email1' => $input['email1'], 'email2' => $input['email2'], 'phone_number1' => $input['phone_number1'], 'phone_number2' => $input['phone_number2'], 'address' => $input['address'], 'iframe' => $input['iframe'], 'video_link' => $input['video_link'], 'facebook_link' => $input['facebook_link'], 'youtube_link' => $input['youtube_link'], 'whatsapp_number' => $input['whatsapp_number'], 'instagram_link' => $input['instagram_link']]);
            if ($request->file('logo')) {
                $file = $request->file('logo');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('images/siteSetting'), $filename);
                $updateData['logo'] = $filename;
            }
            // Insert or Update Site Setting in site_settings Table
            $data = SiteSetting::updateOrInsert(
                ['id' => 1],
                $updateData
            );
            return $this->sendResponse([], 'Site Setting Updated successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }

    public function siteSettingShow()
    {
        try {
            $data = SiteSetting::select('logo',  'email1', 'email2', 'phone_number1', 'phone_number2', 'address', 'iframe', 'video_link', 'facebook_link', 'instagram_link', 'youtube_link', 'whatsapp_number')->first();
            if (is_null($data)) {
                return $this->sendError('Site Setting not found.');
            }
            return $this->sendResponse($data, 'Site Setting retrieved successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }
}