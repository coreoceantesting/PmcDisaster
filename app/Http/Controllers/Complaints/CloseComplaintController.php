<?php

namespace App\Http\Controllers\Complaints;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Complaints\StoreClosureDetailsRequest;
use App\Models\ComplaintType;
use App\Models\ComplaintSubType;
use App\Models\Department;
use App\Models\Complaint;
use App\Models\Loss;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CloseComplaintController extends Controller
{
    public function closeComplaint(Request $request, $id)
    {
        $complaintDetail = Complaint::findOrFail($id);
        $losses = Loss::latest()->get();
        return view('Complaints.closeComplaintForm')->with(['complaintDetail' => $complaintDetail, 'losses' => $losses]);
    }

    public function storeClosureDetails(StoreClosureDetailsRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();

            if ($request->hasFile('upload_doc')) {
                $Doc = $request->file('upload_doc');
                $DocPath = $Doc->store('closer_call_upload_doc', 'public');
                $input['upload_doc'] = $DocPath;
            }
            
            $input['complaint_id'] = $request->input('complaint_id');
            $input['created_at'] = now();

            DB::table('closure_details')->insert($input);

            DB::table('complaints')->where('id', $request->input('complaint_id'))->update([
                'closing_status' => "Closed",
                'closing_remark' => $request->input('remark'),
                'closing_by' => auth()->user()->id,
                'closing_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'success'=> 'Call Closed successfully!',
            ]);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'closing', 'closing call');
        }
    }

    public function closedComplaintList()
    {
        $query = Complaint::join('complaint_types', 'complaints.complaint_type', '=', 'complaint_types.id')
        ->join('complaint_sub_types', 'complaints.complaint_sub_type', '=', 'complaint_sub_types.id')
        ->select('complaints.*','complaint_types.complaint_type_name', 'complaint_sub_types.complaint_sub_type_name')
        ->where('complaints.approval_status', 'Approved')
        ->where('complaints.closing_status', 'Closed');

        if(auth()->user()->roles->pluck('name')[0] == 'Department')
        {
            $query->whereRaw("FIND_IN_SET(?, complaints.departments)", [auth()->user()->department]);
        }

        $complaintsLists = $query->orderBy('complaints.id', 'desc')->get();
        return view('Complaints.closedComplaintList')->with(['complaintsLists' => $complaintsLists]);
    }
}
