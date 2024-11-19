<!DOCTYPE html>
<html>
<head>
    <title>Daywise Call Report</title>
    <style>
        body { font-family: 'freeserif', 'normal';}
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px 12px; border: 1px solid #000; text-align: center; }
        th { background-color: #f2f2f2; }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            font-size: 12px; /* Small letters */
            text-transform: lowercase; /* Convert text to lowercase */
        }

        .footer td {
            padding: 5px;
        }

        .footer .left {
            text-align: left;
            width: 33%;
        }

        .footer .center {
            text-align: center;
            width: 34%;
        }

        .footer .right {
            text-align: right;
            width: 33%;
        }

        .footer table {
        width: 100%;
        border: none !important;
    }
    </style>
</head>
<body>
    <div style="text-align: center; width: 100%;">
        <img src="{{ public_path('/admin/images/Panvel_Municipal_Corporation.png') }}" height="80" width="90" alt="Left Logo">
    </div>
    <h3 style="text-align: center">Day-wise Call Report</h3>
    <table width="100%">
        <tr>
            <td style="text-align: left; width: 33%;">From Date: {{\Carbon\Carbon::parse($fromdate)->setTimezone('Asia/Kolkata')->format('d-m-Y')  }}</td>
            <td style="text-align: center; width: 33%;">To Date: {{\Carbon\Carbon::parse($todate)->setTimezone('Asia/Kolkata')->format('d-m-Y') }}</td>
            <td style="text-align: center; width: 33%;">{{ empty($departmentName) ? "All" : $departmentName }}</td>
            <td style="text-align: right; width: 33%;">Generated Date:{{\Carbon\Carbon::parse(now())->setTimezone('Asia/Kolkata')->format('d-m-Y') }}</td>
        </tr>
    </table>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th rowspan="2">Sr No.</th>
                <th colspan="2">Emergency Call Details</th>
                <th colspan="2">Event Area Details</th>
                <th colspan="6">Incident Details</th>
                <th rowspan="2">Disaster Type</th>
                <th rowspan="2">Disaster Subtype</th>
                <th rowspan="2">Description</th>
                <th rowspan="2">Location</th>
                <th rowspan="2">Remark</th>
                <th rowspan="2">Close At</th>
                <th rowspan="2">Loss Type</th>
                <th rowspan="2">Description</th>
            </tr>
            <tr>
                <th>Complaint Id</th>
                <th>Call Date</th>
                <th>Caller Name</th>
                <th>Caller Address<br> Mobile No.</th>
                <th colspan="3">Death</th>
                <th colspan="3">Injured</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>Male</th>
                <th>Female</th>
                <th>Child</th>
                <th>Male</th>
                <th>Female</th>
                <th>Child</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if ($complaintsLists->isNotEmpty())
                @foreach ($complaintsLists as $index => $list)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $list->complaint_unique_id }}</td>
                        <td>{{ \Carbon\Carbon::parse($list->created_at)->setTimezone('Asia/Kolkata')->format('d-m-Y h:i:s A') }}</td>
                        <td>{{ $list->caller_name }}</td>
                        <td>{{ $list->caller_address }} <br> {{ $list->caller_mobile_no }} </td>
                        <td>{{ $list->no_of_male_death }}</td>
                        <td>{{ $list->no_of_female_death }}</td>
                        <td>{{ $list->no_of_child_death }}</td>
                        <td>{{ $list->no_of_male_injured }}</td>
                        <td>{{ $list->no_of_female_injured }}</td>
                        <td>{{ $list->no_of_child_injured }}</td>
                        <td>{{ $list->complaint_type_name }}</td>
                        <td>{{ $list->complaint_sub_type_name }}</td>
                        <td>{{ $list->complaint_details }}</td>
                        <td>{{ $list->location }}</td>
                        <td>{{ $list->closing_remark }}</td>
                        <td>{{ $list->closing_at ? \Carbon\Carbon::parse($list->closing_at)->format('d-m-y') : 'Pending' }}</td>
                        <td>{{ $list->loss_type }}</td>
                        <td>{{ $list->description }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="19">No Record Found</td>
                </tr>
            @endif
        </tbody>
    </table>
    <br>    
    {{-- <table class="footer">
        <tr>
            <td class="left">printed by: {{ Auth()->user()->name }}</td>
            <td class="center"></td>
            <td class="right">timestamp: {{ \Carbon\Carbon::parse(now())->setTimezone('Asia/Kolkata')->format('d-m-Y h:i:s A') }}</td>
        </tr>
    </table> --}}
</body>
</html>
