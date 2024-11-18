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
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function departmentWiseReport(Request $request)
    {

        $complaintsQuery = DB::table('departments')
        ->whereNull('departments.deleted_by')
        ->leftJoin('complaints', function ($join) {
            $join->whereRaw("FIND_IN_SET(departments.id, complaints.departments)");
        })
        ->select(
            'departments.id',
            'departments.department_name',
            DB::raw('COUNT(complaints.id) as total_count'),
            DB::raw('SUM(complaints.closing_status = "Pending") as pending_count'),
            DB::raw('SUM(complaints.closing_status = "Closed") as closed_count')
        );

        if (Auth::user()->roles->pluck('name')[0] == "Department") {
            $complaintsQuery->where('departments.id', auth()->user()->department);
        }

        $complaintsLists = $complaintsQuery->groupBy('departments.id', 'departments.department_name')->get();

        return view('Reports.departmentWiseReport')->with(['complaintsLists' => $complaintsLists]);
    }

    public function dayWiseCallReport(Request $request)
    {
        $department_list = Department::latest()->get();
        return view('Reports.dayWiseCallReport')->with(['department_list' => $department_list]);
    }

    public function dayWiseCallReportPdf(Request $request)
    {
        // Validate the date inputs (optional but recommended)
        $request->validate([
            'fromdate' => 'required|date',
            'todate' => 'required|date|after_or_equal:fromdate',
            'department' => 'required',
        ]);

        // Retrieve the fromdate and todate values
        $fromdate = $request->input('fromdate');
        $todate = $request->input('todate');
        $department = $request->input('department');
        $departmentName = "";

        // Start the query
        $query = Complaint::leftJoin('complaint_types', 'complaints.complaint_type', '=', 'complaint_types.id')
            ->leftJoin('complaint_sub_types', 'complaints.complaint_sub_type', '=', 'complaint_sub_types.id')
            ->leftJoin('closure_details', 'complaints.id', '=', 'closure_details.complaint_id')
            // ->where('complaints.approval_status', 'Approved')
            ->select(
                'complaints.*',
                'complaint_types.complaint_type_name',
                'complaint_sub_types.complaint_sub_type_name',
                'closure_details.no_of_male_injured',
                'closure_details.no_of_female_injured',
                'closure_details.no_of_child_injured',
                'closure_details.no_of_male_death',
                'closure_details.no_of_female_death',
                'closure_details.no_of_child_death',
                'closure_details.loss_type',
                'closure_details.description'
            );

        if (Auth::user()->roles->pluck('name')[0] == "Department") {
            $query->whereRaw("FIND_IN_SET(?, complaints.departments)", [auth()->user()->department]);
        }

        if($department !== "all")
        {
            $query->whereRaw("FIND_IN_SET(?, complaints.departments)", [$department]);
            $department = Department::find($department);
            $departmentName = $department->department_name;
        }

        // Conditionally add the date filter if both fromdate and todate are provided
        if ($fromdate && $todate) {
            $endOfTodate = \Carbon\Carbon::parse($todate)->endOfDay();
            $query->whereBetween('complaints.created_at', [$fromdate, $endOfTodate]);
        }

        // Execute the query
        $complaintsLists = $query->get();
        

        $html = view('Reports.dayWiseCallReportPdf', compact('complaintsLists', 'fromdate', 'todate', 'departmentName'))->render();
        $mpdf = new Mpdf(
            [
                'mode' => 'utf-8',
                'format' => 'A4',
            ]
        );
        $mpdf->WriteHTML($html);
        $mpdf->Output('day_wise_calls_register.pdf', 'I');
    }
}
