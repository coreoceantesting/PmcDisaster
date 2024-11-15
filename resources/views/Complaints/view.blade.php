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
                            <th>Accpeted Status</th>
                            @php
                                $color = ($complaintsDetail->approval_status == "Approved") ? 'green' : 'red';
                            @endphp
                            <td>
                                <span class="badge" style="background-color: {{ $color }};">
                                    {{ $complaintsDetail->approval_status }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Approval Remark</th>
                            <td>{{ $complaintsDetail->approval_remark ?? 'NA' }}</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="card-footer text-center">
            {{-- @if ($complaintsDetail->approval_status == "Pending" && auth()->user()->roles->pluck('name')[0] == 'Department')
                <button id="approve" class="btn btn-sm btn-success approve-element" data-id="{{ $complaintsDetail->id }}">Accept</button>
                <button id="transfer" class="btn btn-sm btn-danger transfer-element" data-id="{{ $complaintsDetail->id }}">Transfer</button> 
            @endif --}}
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-info">Back</a>
        </div>

        <!-- Approve Modal -->
        <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approveModalLabel">Accept Complaint</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="approveForm">
                            <input type="hidden" id="complaint_id" name="complaint_id">
                            <div class="mb-3">
                            <label for="remark" class="form-label">Remark</label>
                            <textarea class="form-control" id="remark" name="remark" rows="3" required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveRemark" class="btn btn-primary">Accpet</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transfer Modal -->
        <div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="transferModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transferModalLabel">Transfer Complaint</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="transferForm">
                            <input type="hidden" id="transfer_complaint_id" name="transfer_complaint_id">
                            <div class="mb-3">
                                <label for="departments" class="form-label">Departments</label>
                                <select class="js-example-basic-single" name="departments[]" id="departments" multiple required>
                                    <option value="" disabled>Select Department</option>
                                    @foreach ($departmentList as $item)
                                        <option value="{{ $item->id }}">{{ $item->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="transferRemark" class="btn btn-primary">Transfer</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-admin.layout>

{{-- Accept Complain --}}
<script>
    $(document).ready(function() {
      $('.approve-element').on('click', function() {
        var complaintId = $(this).data('id'); 
        $('#complaint_id').val(complaintId); 
        $('#approveModal').modal('show');
      });
     
      $('#saveRemark').on('click', function() {
        var id = $('#complaint_id').val();
        var remark = $('#remark').val();
    
        if(remark === '') {
          alert('Remark is required');
          return;
        }
    
        $.ajax({
          url: '{{ route("accept.complaint") }}',
          type: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            id: id,
            remark: remark
          },
          success: function(data)
            {
                $("#editSubmit").prop('disabled', false);
                if (!data.error2)
                    swal("Successful!", data.success, "success")
                        .then((action) => {
                            window.location.href = '{{ route('complaints.index') }}';
                        });
                else
                    swal("Error!", data.error2, "error");
            },
        });
      });
    });
</script>

{{-- transfer Complaint --}}
<script>
    $(document).ready(function() {

      $('.transfer-element').on('click', function() {
        var transferComplaintId = $(this).data('id'); 
        $('#transfer_complaint_id').val(transferComplaintId); 
        $('#transferModal').modal('show');
      });
    
      // Handle form submission
      $('#transferRemark').on('click', function() {
        var transferComplaintId = $('#transfer_complaint_id').val();
        var departments = $('#departments').val();
    
        if(departments === '') {
          alert('Department is required');
          return;
        }

        $.ajax({
          url: '{{ route("transfer.complaint") }}',
          type: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            transferComplaintId: transferComplaintId,
            departments: departments
          },
          success: function(data)
            {

                if (!data.error2)
                    swal("Successful!", data.success, "success")
                        .then((action) => {
                            window.location.href = '{{ route('complaints.index') }}';
                        });
                else
                    swal("Error!", data.error2, "error");
            },
        });
      });
    });
</script>