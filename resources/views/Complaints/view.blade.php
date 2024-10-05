<x-admin.layout>
    <x-slot name="title">View Complaint Details</x-slot>
    <x-slot name="heading">View Complaint Details</x-slot>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">View Complaint Details</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>Complaint No</th>
                            <td>{{ $complaintsDetail->complaint_unique_id }}</td>
                            <th>Complaint Type</th>
                            <td>{{ $complaintsDetail->complaint_type_name }}</td>
                        </tr>
                        <tr>
                            <th>Complaint Sub Type</th>
                            <td>{{ $complaintsDetail->complaint_sub_type_name }}</td>
                            <th>Manual Complaint No</th>
                            <td>{{ $complaintsDetail->manual_complaint_no ?? 'NA' }}</td>
                        </tr>
                        <tr>
                            <th>Caller Name</th>
                            <td>{{ $complaintsDetail->caller_name }}</td>
                            <th>Caller Mobile No</th>
                            <td>{{ $complaintsDetail->caller_mobile_no }}</td>
                        </tr>
                        <tr>
                            <th>Caller Address</th>
                            <td>{{ $complaintsDetail->caller_address }}</td>
                            <th>Complaint Details</th>
                            <td>{{ $complaintsDetail->complaint_details }}</td>
                        </tr>
                        <tr>
                            <th>Location</th>
                            <td>{{ $complaintsDetail->location }}</td>
                            <th>Departments</th>
                            <td>{{ $departmentNames }}</td>
                        </tr>
                        <tr>
                            <th>Attached Document</th>
                            <td>
                                @if (!empty($complaintsDetail->uploaded_doc))
                                    <a href="{{ asset('storage/'.$complaintsDetail->uploaded_doc) }}" target="blank">View Document</a>
                                @else
                                    NA       
                                @endif
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="card-footer text-center">
            @if ($complaintsDetail->approval_status == "Pending" && auth()->user()->roles->pluck('name')[0] == 'Department')
                <button id="approve" class="btn btn-sm btn-success">Accept</button>
                <button id="reject" class="btn btn-sm btn-danger">Reject</button> 
            @endif
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-info">Back</a>
        </div>
    </div>

</x-admin.layout>