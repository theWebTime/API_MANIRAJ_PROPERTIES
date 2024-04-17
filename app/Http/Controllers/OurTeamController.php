<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Exception;
use Illuminate\Support\Facades\DB;
use App\Models\OurTeam;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController as BaseController;

class OurTeamController extends BaseController
{
    public function index(Request $request)
    {
        try {
            $data = OurTeam::select('id', 'name', 'role')->where(function ($query) use ($request) {
                if ($request->search != null) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                }
            })->orderBy('id', 'DESC')->paginate($request->itemsPerPage ?? 10);
            return $this->sendResponse($data, 'Our Team Data retrieved successfully.');
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
                'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
                'name' => 'required|string|max:20',
                'role' => 'required|string|max:20',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $updateData = (['name' => $input['name'], 'role' => $input['role']]);
            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('images/ourTeam'), $filename);
                $updateData['image'] = $filename;
            }
            // Insert or Update Residentials in residentials Table
            $data = OurTeam::insert($updateData);
            return $this->sendResponse($data, 'Our Team created successfully.');
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
                'our_team_show' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $data = OurTeam::where('id', $request->input('our_team_show'))->select('id', 'name', 'image', 'role')->first();
            if (is_null($data)) {
                return $this->sendError('Data not found.');
            }
            return $this->sendResponse($data, 'Our Team retrieved successfully.');
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
                'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
                'name' => 'required|string|max:20',
                'role' => 'required|string|max:20',
                'our_team_update' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $updateData = (['name' => $input['name'], 'role' => $input['role']]);
            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('images/ourTeam'), $filename);
                $updateData['image'] = $filename;
            }
            // Insert or Update Our Team in our_teams Table
            OurTeam::where('id', $request->input('our_team_update'))->update($updateData);
            return $this->sendResponse([], 'Our Team updated successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }

    public function delete(Request $request)
    {
        //Using Try & Catch For Error Handling
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'our_team_delete' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $data = DB::table('our_teams')->where('id', $request->input('our_team_delete'))->first();
            $path = public_path() . "/images/ourTeam/" . $data->image;
            unlink($path);
            DB::table('our_teams')->where('id', $request->input('our_team_delete'))->delete();
            return $this->sendResponse([], 'Our Team deleted successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }

    public function showAllOurTeam()
    {
        //Using Try & Catch For Error Handling
        try {
            $data = OurTeam::select('id', 'name', 'image', 'role')->get();
            return $this->sendResponse($data, 'All Team Member retrieved successfully.');
        } catch (Exception $e) {
            return $this->sendError('something went wrong!', $e);
        }
    }
}
