<x-admin.layout>
    <x-slot name="title">Complaints List</x-slot>
    <x-slot name="heading">Complaints List</x-slot>
   
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
                                                @can(['complaints.edit'])   
                                                    <a href="{{ route('complaints.edit', $list->id) }}" class="edit-element btn btn-sm btn-warning px-2 py-1" title="Edit Complaint" data-id="{{ $list->id }}"><i class="ri-edit-box-line"></i></a>
                                                @endcan
                                                @can(['complaints.delete'])
                                                    <button class="btn btn-sm btn-dark rem-element px-2 py-1" title="Delete Complaint" data-id="{{ $list->id }}"><i data-feather="trash-2"></i> </button>    
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

<!-- Delete -->
<script>
    $("#buttons-datatables").on("click", ".rem-element", function(e) {
        e.preventDefault();
        swal({
            title: "Are you sure to delete this complaint?",
            // text: "Make sure if you have filled Vendor details before proceeding further",
            icon: "info",
            buttons: ["Cancel", "Confirm"]
        })
        .then((justTransfer) =>
        {
            if (justTransfer)
            {
                var model_id = $(this).attr("data-id");
                var url = "{{ route('complaints.destroy', ":model_id") }}";

                $.ajax({
                    url: url.replace(':model_id', model_id),
                    type: 'POST',
                    data: {
                        '_method': "DELETE",
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function(data, textStatus, jqXHR) {
                        if (!data.error && !data.error2) {
                            swal("Success!", data.success, "success")
                                .then((action) => {
                                    window.location.reload();
                                });
                        } else {
                            if (data.error) {
                                swal("Error!", data.error, "error");
                            } else {
                                swal("Error!", data.error2, "error");
                            }
                        }
                    },
                    error: function(error, jqXHR, textStatus, errorThrown) {
                        swal("Error!", "Something went wrong", "error");
                    },
                });
            }
        });
    });
</script>
