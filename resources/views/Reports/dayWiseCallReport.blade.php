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
                        <form action="{{route('dayWiseCallReportPdf')}}" method="GET">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="fromdate"> From date </label>
                                    <input class="form-control" type="date" name="fromdate" id="fromdate">
                                </div>
                                <div class="col-md-4">
                                    <label for="fromdate"> To date </label>
                                    <input class="form-control" type="date" name="todate" id="todate">
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary mt-4">Genarate PDF</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>




</x-admin.layout>
