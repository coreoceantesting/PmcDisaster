<x-admin.layout>
    <x-slot name="title">View Complaint Details</x-slot>
    <x-slot name="heading">View Complaint Details</x-slot>

    <div class="card">
        
        <div class="card-header">
            <h3 class="card-title text-center">Complaint Details</h3>
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
                            <th>Accpeted Status</th>
                            <td><span class="badge" style="background-color: black"> {{ $complaintsDetail->approval_status }} </span></td>
                        </tr>
                        <tr>
                            <th>Approval Remark</th>
                            <td>{{ $complaintsDetail->approval_remark ?? 'NA' }}</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        @if ($closureDetails > 0)
            <div class="card-header">
                <h3 class="card-title text-center">Closure Details</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>No Of Male Injured</th>
                                <td>{{ $complaintsDetail->no_of_male_injured }}</td>
                                <th>No Of Female Injured</th>
                                <td>{{ $complaintsDetail->no_of_female_injured }}</td>
                            </tr>
                            <tr>
                                <th>No Of Child Injured</th>
                                <td>{{ $complaintsDetail->no_of_child_injured }}</td>
                                <th>Total Injured</th>
                                <td>{{ $complaintsDetail->total_injured ?? 'NA' }}</td>
                            </tr>
                            <tr>
                                <th>No Of Male death</th>
                                <td>{{ $complaintsDetail->no_of_male_death }}</td>
                                <th>No Of Female death</th>
                                <td>{{ $complaintsDetail->no_of_female_death }}</td>
                            </tr>
                            <tr>
                                <th>No Of Child death</th>
                                <td>{{ $complaintsDetail->no_of_child_death }}</td>
                                <th>Total death</th>
                                <td>{{ $complaintsDetail->total_death ?? 'NA' }}</td>
                            </tr>
                            <tr>
                                <th>Remark</th>
                                <td>{{ $complaintsDetail->remark }}</td>
                                <th>Attached Document</th>
                                <td>
                                    @if (!empty($complaintsDetail->upload_doc))
                                        <a href="{{ asset('storage/'.$complaintsDetail->upload_doc) }}" target="blank">View Document</a>
                                    @else
                                        NA       
                                    @endif
                                </td>
                                
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        @endif

        <div class="card-footer text-center">
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-info">Back</a>
        </div>

    </div>

</x-admin.layout>

