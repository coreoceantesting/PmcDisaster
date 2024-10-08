<?php

namespace App\Http\Controllers\Complaints;

use App\Http\Controllers\Controller;
use App\Models\ComplaintType;
use App\Models\ComplaintSubType;
use App\Models\Department;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function departmentWiseReport(Request $request)
    {

        $complaintsLists = DB::table('departments')
        ->whereNull('departments.deleted_by')
        ->leftJoin('complaints', function ($join) {
            $join->whereRaw("FIND_IN_SET(departments.id, complaints.departments)");
        })
        ->select(
            'departments.id',
            'departments.department_name',
            DB::raw('COUNT(complaints.id) as total_count'),
            DB::raw('SUM(complaints.approval_status = "Pending") as pending_count'),
            DB::raw('SUM(complaints.approval_status = "Approved" AND complaints.closing_status = "Closed") as closed_count')
        )
        ->groupBy('departments.id', 'departments.department_name')
        ->get();

        return view('Reports.departmentWiseReport')->with(['complaintsLists' => $complaintsLists]);
    }

    public function dayWiseCallReport(Request $request)
    {
        $complaintsLists = Complaint::leftjoin('complaint_types', 'complaints.complaint_type', '=', 'complaint_types.id')
        ->leftjoin('complaint_sub_types', 'complaints.complaint_sub_type', '=', 'complaint_sub_types.id')
        ->leftjoin('closure_details', 'complaints.id', '=', 'closure_details.complaint_id')
        ->select(
            'complaints.*','complaint_types.complaint_type_name', 'complaint_sub_types.complaint_sub_type_name',
            'closure_details.no_of_male_injured',
            'closure_details.no_of_female_injured',
            'closure_details.no_of_child_injured',
            'closure_details.no_of_male_death',
            'closure_details.no_of_female_death',
            'closure_details.no_of_child_death',
            )
        ->get();

        return view('Reports.dayWiseCallReport')->with(['complaintsLists' => $complaintsLists]);
    }
}