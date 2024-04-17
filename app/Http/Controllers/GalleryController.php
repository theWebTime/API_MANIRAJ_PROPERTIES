<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Gallery;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController as BaseController;

class GalleryController extends BaseController
{
    public function index(Request $request)
    {
        try {
            $data = Gallery::select('id', 'data')->orderBy('id', 'DESC')->paginate($request->itemsPerPage ?? 10);
            return $this->sendResponse($data, 'Gallery Data retrieved successfully.');
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
                'files.*' => 'required|mimes:jpg,jpeg,png,bmp,mp4|max:20000'
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            foreach ($input['files'] as $data) {
                $filename = rand(11111, 99999) . strtotime("now") . '.' . $data->getClientOriginalExtension();
                $data->move(public_path('images/gallery'), $filename);
                Gallery::insert(['data' => $filename]);
            }
            return $this->sendResponse([], 'Gallery created successfully.');
        } catch (Exception $e) {
            return $e;
            return $this->sendError('something went wrong!', $e);
        }
    }

    public function delete(Request $request)
    {
        //Using Try & Catch For Error Handling
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'gallery_delete' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $data = DB::table('galleries')->where('id', $request->input('gallery_delete'))->first();
            $path = public_path() . "/images/gallery/" . $data->data;
            unlink($path);
            DB::table('galleries')->where('id', $request->input('gallery_delete'))->delete();
            return $this->sendResponse([], 'Gallery deleted successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }

    public function showAllGallery()
    {
        //Using Try & Catch For Error Handling
        try {
            $data = Gallery::select('id', 'image')->get();
            if (is_null($data)) {
                return $this->sendError('Data not found.');
            }
            return $this->sendResponse($data, 'Gallery retrieved successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }
}
