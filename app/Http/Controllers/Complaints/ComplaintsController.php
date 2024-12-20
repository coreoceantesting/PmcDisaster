<?php

namespace App\Http\Controllers\Complaints;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Complaints\StoreComplaintsRequest;
use App\Http\Requests\Admin\Complaints\UpdateComplaintsRequest;
use App\Models\ComplaintType;
use App\Models\ComplaintSubType;
use App\Models\Department;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ComplaintsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Complaint::join('complaint_types', 'complaints.complaint_type', '=', 'complaint_types.id')
        ->join('complaint_sub_types', 'complaints.complaint_sub_type', '=', 'complaint_sub_types.id')
        ->select('complaints.*','complaint_types.complaint_type_name', 'complaint_sub_types.complaint_sub_type_name')
        ->where('complaints.closing_status', 'Pending')
        ->orwhere('complaints.closing_status', 'WIP');

        if(auth()->user()->roles->pluck('name')[0] == 'Department')
        {
            $query->whereRaw("FIND_IN_SET(?, complaints.departments)", [auth()->user()->department]);
        }

        $complaintsLists = $query->orderBy('complaints.id', 'desc')->get();
        return view('Complaints.list')->with(['complaintsLists' => $complaintsLists]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $complaint_types = ComplaintType::latest()->get();
        $departments = Department::latest()->get();
        return view('Complaints.create')->with(['complaint_types' => $complaint_types, 'departments' => $departments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComplaintsRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();

            // Get the count of existing complaints for the current year
            $currentYear = date('Y');
            $lastNumber = Complaint::whereYear('created_at', $currentYear)->count();

            // Increment the last number and pad it with leading zeros
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

            // Create the application number with the new sequence number
            $applicationNo = "DM/" . $currentYear . "/" . $newNumber;
            $input['complaint_unique_id'] = $applicationNo;

            $input['departments'] = implode(',', $input['departments']);

            if ($request->hasFile('uploaded_doc')) {
                $Doc = $request->file('uploaded_doc');
                $DocPath = $Doc->store('uploaded_doc', 'public');
                $input['uploaded_doc'] = $DocPath;
            }

            $complaint = Complaint::create($input);
            
            // Create a notification
            DB::table('notifications')->insert([
                'user_id' => auth()->user()->id, 
                'complaint_id' => $complaint->id,
                'departmentids' =>  $input['departments'],
                'message' => 'A New Complaint Generated', 
            ]);

            DB::commit();

            return response()->json(['success' => $applicationNo . ' Complaint registered successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'creating', 'Complaint Register');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $complaintsDetail = Complaint::leftjoin('complaint_types', 'complaints.complaint_type', '=', 'complaint_types.id')
        ->leftjoin('complaint_sub_types', 'complaints.complaint_sub_type', '=', 'complaint_sub_types.id')
        ->leftjoin('users', 'complaints.action_taken_by', '=', 'users.id')
        ->select('complaints.*','complaint_types.complaint_type_name', 'complaint_sub_types.complaint_sub_type_name', 'users.name as username')
        ->where('complaints.id', $id)
        ->first();
        $departmentIds = explode(',', $complaintsDetail->departments);
        $departments = Department::whereIn('id', $departmentIds)->pluck('department_name')->toArray();
        $departmentNames = implode(', ', $departments);
        $departmentList = Department::whereNot('id', auth()->user()->department)->latest()->get(['id', 'department_name']);

        return view('Complaints.view')->with(['complaintsDetail' => $complaintsDetail, 'departmentNames' => $departmentNames, 'departmentList' => $departmentList]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $complaintsDetail = Complaint::findOrFail($id);
        $complaint_types = ComplaintType::latest()->get();
        $departments = Department::latest()->get();
        $selectedDepartment = explode(',', $complaintsDetail->departments);

        return view('Complaints.edit')->with([
         'complaintsDetail' => $complaintsDetail,
         'departments' => $departments,
         'complaint_types' => $complaint_types,
         'selectedDepartment' => $selectedDepartment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComplaintsRequest $request, $id)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $complaintDetail = Complaint::findOrFail($id);

            $input['departments'] = implode(',', $input['departments']);

            if ($request->hasFile('uploaded_doc')) {

                if (!empty($complaintDetail->uploaded_doc)) {
                    Storage::disk('public')->delete($complaintDetail->uploaded_doc);
                }

                $Doc = $request->file('uploaded_doc');
                $DocPath = $Doc->store('uploaded_doc', 'public');
                $input['uploaded_doc'] = $DocPath;
            }

            $complaintDetail->update($input);
            DB::commit();

            return response()->json(['success'=> 'Complaint updated successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'Complaint');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        try
        {
            DB::beginTransaction();
            $complaint->delete();
            DB::commit();

            return response()->json(['success'=> 'Complaint deleted successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'deleting', 'Complaint');
        }
    }

    public function getComplaintSubTypes(Request $request)
    {
        $subtypes = ComplaintSubType::where('complaint_type', $request->complaint_type_id)->get();
        return response()->json($subtypes);
    }

    public function accepetedComplaintList()
    {
        $query = Complaint::join('complaint_types', 'complaints.complaint_type', '=', 'complaint_types.id')
        ->join('complaint_sub_types', 'complaints.complaint_sub_type', '=', 'complaint_sub_types.id')
        ->select('complaints.*','complaint_types.complaint_type_name', 'complaint_sub_types.complaint_sub_type_name')
        ->where('complaints.approval_status', 'Approved')
        ->where('complaints.closing_status', 'Pending');

        if(auth()->user()->roles->pluck('name')[0] == 'Department')
        {
            $query->whereRaw("FIND_IN_SET(?, complaints.departments)", [auth()->user()->department]);
        }

        $complaintsLists = $query->orderBy('complaints.id', 'desc')->get();
        return view('Complaints.approvedList')->with(['complaintsLists' => $complaintsLists]);
    }

    public function accepetComplaint(Request $request)
    {
        try
        {
            DB::beginTransaction();
            $complaintId = $request->input('id');
            $remark = $request->input('remark');

            DB::table('complaints')->where('id', $complaintId)->update([
                'approval_status' => 'Approved',
                'approval_remark' => $remark,
                'approval_by' => auth()->user()->id,
                'approval_at' => now()
            ]);
            
            DB::commit();

            return response()->json(['success'=> 'Complaint Approved Successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'Approving', 'Complaint');
        }
    }

    public function transferComplaint(Request $request)
    {
        try
        {
            DB::beginTransaction();
            $complaintId = $request->input('transferComplaintId');
            $departments = implode(',', $request->input('departments'));

            DB::table('complaints')->where('id', $complaintId)->update([
                'departments' => $departments,
            ]);
            
            DB::commit();

            return response()->json(['success'=> 'Complaint Transfered Successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'transfering', 'Complaint');
        }
    }

    public function viewComplaintDetails(Request $request, $id)
    {
        $complaintsDetail = Complaint::join('complaint_types', 'complaints.complaint_type', '=', 'complaint_types.id')
        ->join('complaint_sub_types', 'complaints.complaint_sub_type', '=', 'complaint_sub_types.id')
        ->join('closure_details', 'complaints.id', '=', 'closure_details.complaint_id')
        ->select('complaints.*','complaint_types.complaint_type_name', 'complaint_sub_types.complaint_sub_type_name', 'closure_details.*')
        ->where('complaints.id', $id)
        ->first();

        $closureDetails = DB::table('closure_details')->where('complaint_id', $id)->count();

        $departmentIds = explode(',', $complaintsDetail->departments);
        $departments = Department::whereIn('id', $departmentIds)->pluck('department_name')->toArray();
        $departmentNames = implode(', ', $departments);

        return view('Complaints.finalView')->with([
            'complaintsDetail' => $complaintsDetail,
            'departmentNames' => $departmentNames,
            'closureDetails' => $closureDetails
        ]);
    }

    public function takeActionOnComplaint(Request $request)
    {
        try
        {
            DB::beginTransaction();
            $complaintId = $request->input('id');
            $remark = $request->input('remark');

            DB::table('complaints')->where('id', $complaintId)->update([
                'closing_status' => 'WIP',
                'action_remark' => $remark,
                'action_taken_by' => auth()->user()->id,
                'action_taken_at' => now()
            ]);
            
            DB::commit();

            return response()->json(['success'=> 'Action Taken On Complaint Successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'Action Taken', 'Complaint');
        }
    }

    public function getCount()
    {
        $count = DB::table('notifications')
                    ->where('is_read', 0)
                    ->count();

        return response()->json(['count' => $count]);
    }

    public function getNotifications()
    {
        $query = DB::table('notifications')
                            ->join('complaints', 'notifications.complaint_id', '=', 'complaints.id');
        if(auth()->user()->roles->pluck('name')[0] == 'Department')
        {
            $query->whereRaw("FIND_IN_SET(?, notifications.departmentids)", [auth()->user()->department]);
        }

        $notifications =  $query->orderBy('notifications.id', 'desc')
        ->take(5)
        ->get(['notifications.*', 'complaints.complaint_unique_id', 'complaints.caller_name']);

        return response()->json(['notifications' => $notifications]);
    }

    public function markAsRead($id)
    {
        $notification = DB::table('notifications')->where('id', $id)->first();

        if (!$notification) {
            return response()->json(['error' => 'Notification not found.'], 404);
        }

        // Assuming 'is_read' is a boolean field in your notifications table
        DB::table('notifications')->where('id', $id)->update(['is_read' => 1]);

        return response()->json(['message' => 'Notification marked as read.']);
    }

    public function markAllAsRead()
    {
        // Assuming 'is_read' is a boolean field in your notifications table
        DB::table('notifications')->where('is_read', 0)->update(['is_read' => 1]);

        return response()->json(['message' => 'All notifications marked as read.']);
    }

}
