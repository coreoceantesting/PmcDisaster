<x-admin.layout>
    <x-slot name="title">No Data Found</x-slot>
    <x-slot name="heading">No Data Found</x-slot>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-danger" role="alert">
                        No Data Found
                    </div>
                    <div class="text-center">
                        <a href="{{ route('dayWiseCallReport') }}" class="btn btn-sm btn-primary">Back</a>
                    </div>  
                </div>
            </div>
        </div>
    </div>

</x-admin.layout>