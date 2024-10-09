<x-admin.layout>
    <x-slot name="title">Accpeted Complaints List</x-slot>
    <x-slot name="heading">Accpeted Complaints List</x-slot>
   
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="buttons-datatables" class="table table-bordered nowrap align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Complaint ID</th>
                                        <th>Complaint Type</th>
                                        <th>Complaint Sub Type</th>
                                        <th>Caller Name</th>
                                        <th>Caller Mobile No</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($complaintsLists as $index => $list)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $list->complaint_unique_id }}</td>
                                            <td>{{ $list->complaint_type_name }}</td>
                                            <td>{{ $list->complaint_sub_type_name }}</td>
                                            <td>{{ $list->caller_name }}</td>
                                            <td>{{ $list->caller_mobile_no }}</td>
                                            <td>
                                                <a href="{{ route('complaints.show', $list->id) }}" class="view-element btn btn-sm btn-primary px-2 py-1" title="View Complaint" data-id="{{ $list->id }}"><i class="ri-eye-line"></i></a>
                                                @can(['complaints.closecall']) 
                                                    <a href="{{ route('complaints.close', $list->id) }}" class="close-complaint btn btn-sm btn-dark px-2 py-1" title="Close Complaint" data-id="{{ $list->id }}">Close Call</a>
                                                @endcan
                                            </td>
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

