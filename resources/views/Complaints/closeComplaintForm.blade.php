<x-admin.layout>
    <x-slot name="title">Call Closure Details Form</x-slot>
    <x-slot name="heading">Call Closure Details Form</x-slot>


        <!-- Add Form -->
        <div class="row" id="addContainer">
            <div class="col-sm-12">
                <div class="card">
                    <form class="theme-form" name="addForm" id="addForm" enctype="multipart/form-data">
                        @csrf

                        <div class="card-header">
                            <h4 class="card-title">Call Closure Details Form</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <input type="hidden" name="complaint_id" id="complaint_id" value="{{ $complaintDetail->id }}">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="no_of_male_injured">No Of Male Injured</label>
                                    <input class="form-control numeric-only" id="no_of_male_injured" name="no_of_male_injured" value="0" type="number" placeholder="Enter No Of Male Injured" min="0">
                                    <span class="text-danger is-invalid no_of_male_injured_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="no_of_female_injured">No Of Female Injured</label>
                                    <input class="form-control numeric-only" id="no_of_female_injured" name="no_of_female_injured" value="0" type="number" placeholder="Enter No Of Female Injured" min="0">
                                    <span class="text-danger is-invalid no_of_female_injured_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="no_of_child_injured">No Of Child Injured</label>
                                    <input class="form-control numeric-only" id="no_of_child_injured" name="no_of_child_injured" value="0" type="number" placeholder="Enter No Of Child Injured" min="0">
                                    <span class="text-danger is-invalid no_of_child_injured_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="total_injured">Total Injured</label>
                                    <input class="form-control numeric-only" id="total_injured" name="total_injured" type="number" value="0" placeholder="Enter No Of Total Injured" min="0">
                                    <span class="text-danger is-invalid total_injured_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="no_of_male_death">No Of Male Death</label>
                                    <input class="form-control numeric-only" id="no_of_male_death" name="no_of_male_death" value="0" type="number" placeholder="Enter No Of Male Death" min="0">
                                    <span class="text-danger is-invalid no_of_male_death_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="no_of_female_death">No Of Female Death</label>
                                    <input class="form-control numeric-only" id="no_of_female_death" name="no_of_female_death" value="0" type="number" placeholder="Enter No Of Female Death" min="0">
                                    <span class="text-danger is-invalid no_of_female_death_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="no_of_child_death">No Of Child Death</label>
                                    <input class="form-control numeric-only" id="no_of_child_death" name="no_of_child_death" value="0" type="number" placeholder="Enter No Of Child Death" min="0">
                                    <span class="text-danger is-invalid no_of_child_death_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="total_death">Total Death</label>
                                    <input class="form-control numeric-only" id="total_death" name="total_death" type="number" value="0" placeholder="Enter No Of Total Death" min="0">
                                    <span class="text-danger is-invalid total_death_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="remark">Remark <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="remark" id="remark" cols="30" rows="2" placeholder="Enter Remark"></textarea>
                                    <span class="text-danger is-invalid remark_err"></span>
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="upload_doc">Upload Document</label>
                                    <input class="form-control" type="file" name="upload_doc" id="upload_doc">
                                    <span class="text-danger is-invalid upload_doc_err"></span>
                                </div>

                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="addSubmit">Submit</button>
                            <a href="{{ url()->previous() }}" class="btn btn-warning">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

</x-admin.layout>


{{-- Add --}}
<script>
    $("#addForm").submit(function(e) {
        e.preventDefault();
        $("#addSubmit").prop('disabled', true);

        var formdata = new FormData(this);
        $.ajax({
            url: '{{ route('store.closureDetails') }}',
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: false,
            success: function(data)
            {
                $("#addSubmit").prop('disabled', false);
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
                    $("#addSubmit").prop('disabled', false);
                    resetErrors();
                    printErrMsg(responseObject.responseJSON.errors);
                },
                500: function(responseObject, textStatus, errorThrown) {
                    $("#addSubmit").prop('disabled', false);
                    swal("Error occured!", "Something went wrong please try again", "error");
                }
            }
        });

    });
</script>

<script>
    $(document).on('input', '.numeric-only', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
        updateTotalInjured();
        updateTotalDeath()
    });

    function updateTotalInjured() {
        const maleInjured = parseInt($('#no_of_male_injured').val()) || 0;
        const femaleInjured = parseInt($('#no_of_female_injured').val()) || 0;
        const childInjured = parseInt($('#no_of_child_injured').val()) || 0;

        const totalInjured = maleInjured + femaleInjured + childInjured;

        $('#total_injured').val(totalInjured);
    }

    function updateTotalDeath() {
        const maleDeath = parseInt($('#no_of_male_death').val()) || 0;
        const femaleDeath = parseInt($('#no_of_female_death').val()) || 0;
        const childDeath = parseInt($('#no_of_child_death').val()) || 0;

        const totalDeath = maleDeath + femaleDeath + childDeath;

        $('#total_death').val(totalDeath);
    }
</script>



