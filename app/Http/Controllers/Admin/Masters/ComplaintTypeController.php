<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Masters\ComplaintType\StoreComplaintTypeRequest;
use App\Http\Requests\Admin\Masters\ComplaintType\UpdateComplaintTypeRequest;
use App\Models\ComplaintType;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ComplaintTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $complaintTypes = ComplaintType::latest()->get();

        return view('admin.masters.complaintType')->with(['complaintTypes'=> $complaintTypes]);
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
    public function store(StoreComplaintTypeRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            ComplaintType::create($input);
            DB::commit();

            return response()->json(['success'=> 'Complaint type created successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'creating', 'Complaint type');
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
    public function edit(ComplaintType $complaintType)
    {
        if ($complaintType)
        {
            $response = [
                'result' => 1,
                'complaintType' => $complaintType,
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
    public function update(UpdateComplaintTypeRequest $request, ComplaintType $complaintType)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $complaintType->update($input);
            DB::commit();

            return response()->json(['success'=> 'Complaint type updated successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'Complaint type');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComplaintType $complaintType)
    {
        try
        {
            DB::beginTransaction();
            $complaintType->delete();
            DB::commit();

            return response()->json(['success'=> 'Complaint Type deleted successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'deleting', 'Complaint Type');
        }
    }
}
