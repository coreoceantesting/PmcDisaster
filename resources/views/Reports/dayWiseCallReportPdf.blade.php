<!DOCTYPE html>
<html>
<head>
    <title>Daywise Call Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px 12px; border: 1px solid #000; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h3 style="text-align: center">Day-wise Call Report</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th rowspan="2">Sr No.</th>
                <th colspan="2">Emergency Call Details</th>
                <th colspan="2">Event Area Details</th>
                <th colspan="6">Accident Details</th>
                <th rowspan="2">Disaster Type</th>
                <th rowspan="2">Disaster Subtype</th>
                <th rowspan="2">Description</th>
                <th rowspan="2">Location</th>
                <th rowspan="2">Remark</th>
            </tr>
            <tr>
                <th>Call No</th>
                <th>Date</th>
                <th>Caller Name</th>
                <th>Address<br>Caller Mobile No.</th>
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
            </tr>
        </thead>
        <tbody>
            @foreach ($complaintsLists as $index => $list)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $list->complaint_unique_id }}</td>
                    <td>{{ \Carbon\Carbon::parse($list->created_at)->format('Y-m-d H:i:s') }}</td>
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
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
