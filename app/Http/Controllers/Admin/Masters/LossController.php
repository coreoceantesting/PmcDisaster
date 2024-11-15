<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Masters\LossType\StoreLossRequest;
use App\Http\Requests\Admin\Masters\LossType\UpdateLossRequest;
use App\Models\Loss;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class LossController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lossTypes = Loss::latest()->get();

        return view('admin.masters.lossType')->with(['lossTypes'=> $lossTypes]);
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
    public function store(StoreLossRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            Loss::create($input);
            DB::commit();

            return response()->json(['success'=> 'Loss type created successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'creating', 'Loss type');
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
    public function edit(string $id)
    {
        $lossData = Loss::findOrFail($id);
        if ($lossData)
        {
            $response = [
                'result' => 1,
                'lossData' => $lossData,
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
    public function update(UpdateLossRequest $request, string $id)
    {
        try
        {
            DB::beginTransaction();
            $loss = Loss::findOrFail($id);
            $input = $request->validated();
            $loss->update($input);
            DB::commit();

            return response()->json(['success'=> 'Loss type updated successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'Loss type');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try
        {
            DB::beginTransaction();
            $loss = Loss::findOrFail($id);
            $loss->delete();
            DB::commit();

            return response()->json(['success'=> 'Loss Type deleted successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'deleting', 'Loss Type');
        }
    }
}
