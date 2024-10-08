<x-admin.layout>
    <x-slot name="title">Day Wise Calls Register</x-slot>
    <x-slot name="heading">Day Wise Calls Register</x-slot>
    <style>
        table, th, td {
          text-align: center;
        }
    </style>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
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
                                            <td>{{ $list->created_at }}</td>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>




</x-admin.layout>
