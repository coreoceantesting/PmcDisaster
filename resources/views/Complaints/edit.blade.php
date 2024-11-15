<x-admin.layout>
    <x-slot name="title">Edit Complaint</x-slot>
    <x-slot name="heading">Edit Complaint</x-slot>


        <!-- Add Form -->
        <div class="row" id="addContainer">
            <div class="col-sm-12">
                <div class="card">
                    <form class="theme-form" name="editForm" id="editForm" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="edit_model_id" id="edit_model_id" value="{{$complaintsDetail->id}}">

                        <div class="card-header">
                            <h4 class="card-title">Edit Complaint</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="complaint_type">Complaint Type <span class="text-danger">*</span></label>
                                    <select class="form-control" name="complaint_type" id="complaint_type">
                                        <option value="">Select Complaint Type</option>
                                        @foreach ($complaint_types as $item)
                                            <option value="{{ $item->id }}" @if($complaintsDetail->complaint_type == $item->id) selected  @endif>{{ $item->complaint_type_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid complaint_type_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="complaint_sub_type">Complaint Sub Type <span class="text-danger">*</span></label>
                                    <select class="form-control" name="complaint_sub_type" id="complaint_sub_type">
                                        <option value="">Select Complaint Sub Type</option>
                                    </select>
                                    <span class="text-danger is-invalid complaint_sub_type_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="manual_complaint_no">Manual Complaint No</label>
                                    <input class="form-control" id="manual_complaint_no" name="manual_complaint_no" type="text" value="{{ $complaintsDetail->manual_complaint_no }}" placeholder="Enter Manual Complaint">
                                    <span class="text-danger is-invalid manual_complaint_no_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="caller_name">Caller Name <span class="text-danger">*</span></label>
                                    <input class="form-control" id="caller_name" name="caller_name" type="text" value="{{ $complaintsDetail->caller_name }}" placeholder="Enter Caller Name">
                                    <span class="text-danger is-invalid caller_name_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="caller_mobile_no">Caller Mobile No <span class="text-danger">*</span></label>
                                    <input class="form-control" id="caller_mobile_no" name="caller_mobile_no" value="{{ $complaintsDetail->caller_mobile_no }}" type="number" placeholder="Enter Caller Mobile No">
                                    <span class="text-danger is-invalid caller_mobile_no_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="caller_address">Caller Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="caller_address" id="caller_address" cols="30" rows="2" placeholder="Enter Caller Address">{{ $complaintsDetail->caller_address }}</textarea>
                                    <span class="text-danger is-invalid caller_address_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="location">Incident Location <span class="text-danger">*</span></label>
                                    <input class="form-control" id="location" name="location" type="text" placeholder="Enter Location" value="{{ $complaintsDetail->location }}">
                                    <span class="text-danger is-invalid location_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="complaint_details">Complaint Details <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="complaint_details" id="complaint_details" cols="30" rows="2" placeholder="Enter Complaint Details">{{ $complaintsDetail->complaint_details }}</textarea>
                                    <span class="text-danger is-invalid complaint_details_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="uploaded_doc">Attach Document </label>
                                    <input class="form-control" id="uploaded_doc" name="uploaded_doc" type="file">
                                    @if (!empty($complaintsDetail->uploaded_doc))
                                        <small><a href="{{ asset('storage/'.$complaintsDetail->uploaded_doc) }}" target="_blank">View Document</a></small>
                                    @endif
                                    <span class="text-danger is-invalid uploaded_doc_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="departments">Department <span class="text-danger">*</span></label>
                                    <select class="js-example-basic-single col-sm-12" name="departments[]" id="departments" multiple>
                                        <option value="" disabled>Select Complaint Type</option>
                                        @foreach ($departments as $item)
                                            <option value="{{ $item->id }}" @if(in_array($item->id, $selectedDepartment)) selected @endif>{{ $item->department_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger is-invalid departments_err"></span>
                                </div>




                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-sm btn-primary" id="editSubmit">Submit</button>
                            <a href="{{ url()->previous() }}" class="btn btn-sm btn-info">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

</x-admin.layout>

<script>
    $(document).ready(function() {

        var complaintTypeIdnew = $('#complaint_type').val();
        $('#complaint_sub_type').html('<option value="">Select Complaint Sub Type</option>'); // Reset subtypes

        if (complaintTypeIdnew) {
            $.ajax({
                url: '/complaint-sub-types',
                type: 'GET',
                data: { complaint_type_id: complaintTypeIdnew },
                success: function(response) {
                    $.each(response, function(key, value) {
                        $('#complaint_sub_type').append('<option value="' + value.id + '" selected>' + value.complaint_sub_type_name + '</option>');
                    });
                },
                error: function() {
                    console.log('Error loading complaint sub types');
                }
            });
        }


        $('#complaint_type').on('change', function() {
            var complaintTypeId = $(this).val();
            $('#complaint_sub_type').html('<option value="">Select Complaint Sub Type</option>'); // Reset subtypes

            if (complaintTypeId) {
                $.ajax({
                    url: '/complaint-sub-types',
                    type: 'GET',
                    data: { complaint_type_id: complaintTypeId },
                    success: function(response) {
                        $.each(response, function(key, value) {
                            $('#complaint_sub_type').append('<option value="' + value.id + '">' + value.complaint_sub_type_name + '</option>');
                        });
                    },
                    error: function() {
                        console.log('Error loading complaint sub types');
                    }
                });
            }
        });
    });
</script>

<!-- Update -->
<script>
    $(document).ready(function() {
        $("#editForm").submit(function(e) {
            e.preventDefault();
            $("#editSubmit").prop('disabled', true);
            var formdata = new FormData(this);
            formdata.append('_method', 'PUT');
            var model_id = $('#edit_model_id').val();
            var url = "{{ route('complaints.update', ":model_id") }}";
            //
            $.ajax({
                url: url.replace(':model_id', model_id),
                type: 'POST',
                data: formdata,
                contentType: false,
                processData: false,
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
                statusCode: {
                    422: function(responseObject, textStatus, jqXHR) {
                        $("#editSubmit").prop('disabled', false);
                        resetErrors();
                        printErrMsg(responseObject.responseJSON.errors);
                    },
                    500: function(responseObject, textStatus, errorThrown) {
                        $("#editSubmit").prop('disabled', false);
                        swal("Error occured!", "Something went wrong please try again", "error");
                    }
                }
            });

        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#caller_mobile_no').on('input', function() {
            const mobileInput = $(this);
            const errorMessage = $('.caller_mobile_no_err');
            let mobileNumber = mobileInput.val();

            // Remove any non-digit characters
            mobileNumber = mobileNumber.replace(/\D/g, '');

            // Restrict input to 10 digits only
            if (mobileNumber.length > 10) {
                mobileNumber = mobileNumber.slice(0, 10);
            }

            mobileInput.val(mobileNumber);

            // Check if the input is exactly 10 digits
            if (mobileNumber.length !== 10 && mobileNumber.length > 0) {
                // Show error message
                errorMessage.text("Mobile number must be exactly 10 digits.");
                mobileInput.addClass('is-invalid');
            } else {
                // Clear the error message if valid
                errorMessage.text("");
                mobileInput.removeClass('is-invalid');
            }
        });
    });
</script>



