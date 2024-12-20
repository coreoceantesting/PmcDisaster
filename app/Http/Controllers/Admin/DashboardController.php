<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use App\Models\ComplaintType;
use App\Models\ComplaintSubType;
use App\Models\Department;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{

    public function index()
    {
        $userDepartment = auth()->user()->department;
        $complaintsQuery = Complaint::select(
            // DB::raw('COUNT(id) as total_count'),
            DB::raw('SUM(closing_status = "Pending" || closing_status = "WIP") as pending_count'),
            DB::raw('SUM(closing_status = "Closed") as closed_count')
        );

        $pendingQuery = Complaint::where('closing_status', '=', 'Pending')->orWhere('closing_status', '=', 'WIP');
        $closedQuery = Complaint::where('closing_status', '=', 'Closed');

        if (!empty($userDepartment)) {
            $complaintsQuery->whereRaw("FIND_IN_SET('$userDepartment', departments)");

            $pendingQuery->whereRaw("FIND_IN_SET('$userDepartment', departments)");

            $closedQuery->whereRaw("FIND_IN_SET('$userDepartment', departments)");
        }

        $complaintsLists = $complaintsQuery->first();
        $pendingComplaintsLists = $pendingQuery->latest()->take(5)->get();
        $closedComplaintsLists = $closedQuery->latest()->take(5)->get();

        return view('admin.dashboard')->with([
            'complaintsLists' => $complaintsLists,
            'pendingComplaintsLists' => $pendingComplaintsLists,
            'closedComplaintsLists' => $closedComplaintsLists
        ]);
    }

    public function changeThemeMode()
    {
        $mode = request()->cookie('theme-mode');

        if($mode == 'dark')
            Cookie::queue('theme-mode', 'light', 43800);
        else
            Cookie::queue('theme-mode', 'dark', 43800);

        return true;
    }
}
