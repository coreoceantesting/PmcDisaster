<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Masters\ComplaintSubType\StoreComplaintSubTypeRequest;
use App\Http\Requests\Admin\Masters\ComplaintSubType\UpdateComplaintSubTypeRequest;
use App\Models\ComplaintSubType;
use App\Models\ComplaintType;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ComplaintSubTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $complaintSubTypes = ComplaintSubType::with('type')->latest()->get();
        $complaintTypeLists = ComplaintType::latest()->get();

        return view('admin.masters.complaintSubType')->with(['complaintSubTypes'=> $complaintSubTypes, 'complaintTypeLists' => $complaintTypeLists]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComplaintSubTypeRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            ComplaintSubType::create($input);
            DB::commit();

            return response()->json(['success'=> 'Complaint Sub type created successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'creating', 'Complaint Sub type');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComplaintSubType $complaintSubType)
    {
        if ($complaintSubType)
        {
            $response = [
                'result' => 1,
                'complaintSubType' => $complaintSubType,
            ];
        }
        else
        {
            $response = ['result' => 0];
        }
        return $response;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComplaintSubTypeRequest $request, ComplaintSubType $complaintSubType)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $complaintSubType->update($input);
            DB::commit();

            return response()->json(['success'=> 'Complaint Sub type updated successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'Complaint Sub type');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComplaintSubType $complaintSubType)
    {
        try
        {
            DB::beginTransaction();
            $complaintSubType->delete();
            DB::commit();

            return response()->json(['success'=> 'Complaint Sub Type deleted successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'deleting', 'Complaint Sub Type');
        }
    }
}
