<x-admin.layout>
    <x-slot name="title">Department Wise Report</x-slot>
    <x-slot name="heading">Department Wise Report</x-slot>
   
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="buttons-datatables" class="table table-bordered nowrap align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Department</th>
                                        <th>Total</th>
                                        <th>Pending</th>
                                        <th>Closed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($complaintsLists as $index => $list)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $list->department_name }}</td>
                                            <td>{{ $list->total_count }}</td>
                                            <td>{{ $list->pending_count ?? '0' }}</td>
                                            <td>{{ $list->closed_count ?? '0' }}</td>
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

