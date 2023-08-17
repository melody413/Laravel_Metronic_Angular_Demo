<div class="col-md-12">
    <div class="row">
        <div class="col-md-6 col-lg-6 col-xl-4">
            <div class="widget-panel widget-style-2 bg-white">
                <i class="ti-calendar text-primary"></i>
                <h2 class="m-0 text-dark counter font-600">
                    <?php
                    $visited = count(\App\Model\PatientAppointment::where('status', 1)->where('date', \Carbon\Carbon::today())->get());
                    $total = count(\App\Model\PatientAppointment::where('date', \Carbon\Carbon::today())->get());
                    ?>
                    {{$visited}} / {{$total}}
                </h2>
                <div class="text-muted m-t-5">Today's Appointment</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-4">
            <div class="widget-panel widget-style-2 bg-white">
                <i class="ti-notepad text-pink"></i>
                <h2 class="m-0 text-dark counter font-600">
                    {{count(\App\Model\Prescription::all())}}
                </h2>
                <div class="text-muted m-t-5">Total Prescription</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-4">
            <div class="widget-panel widget-style-2 bg-white">
                <i class="fa fa-money fa-2x -directory text-info"></i>
                <h2 class="m-0 text-dark counter font-600">
                    {{\App\Model\PatientPayment::whereDate('updated_at',\Carbon\Carbon::today())->sum('payment')}}
                </h2>
                <div class="text-muted m-t-5">Today's Earn</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-lg-6 col-xl-4">
            <div class="widget-panel widget-style-2 bg-white">
                <i class="fa fa-users text-primary"></i>
                <h2 id="todays_patient" class="m-0 text-dark counter font-600">
                    0
                </h2>
                <div class="text-muted m-t-5">Today's Patient</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-4">
            <div class="widget-panel widget-style-2 bg-white">
                <i class="fa fa-users text-pink"></i>
                <h2 id="total_patient" class="m-0 text-dark counter font-600">
                    0
                </h2>
                <div class="text-muted m-t-5">Total Patient</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-4">
            <div class="widget-panel widget-style-2 bg-white">
                <i class="fa fa-users -directory text-info"></i>
                <h2 id="patient_latest" class="m-0 text-dark counter font-600">
                    0
                </h2>
                <div class="text-muted m-t-5"> New Patient Last 7 Days</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header card-header-icon">
                    <i class="icon icon-pill"></i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Latest Prescriptions <span id="countPrescription"></span> <small
                                style="font-size: 12px;" class="pull-right">last 7 days</small></h4>
                </div>
                <div class="card-body">
                    <table width="100%" class="table">
                        <tbody id="latestPrescription">
                        <tr>
                            <th>Patient</th>
                            <th>Date</th>
                            <th>Drug Use</th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header card-header-icon">
                    <i class="fa fa-calendar fa-2x"></i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Latest Appointment <span id="countAppointment"></span> <small
                                style="font-size: 12px;" class="pull-right">last 7 days</small></h4>
                </div>
                <div class="card-body">
                    <table width="100%" class="table">
                        <tbody id="latestAppointment">
                        <tr>
                            <th>Patient</th>
                            <th>Appointment Date</th>
                            <th>Appointed by</th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@section('extra-js')
    <script>
        $(document).ready(function () {
            // Get Total Patient
            $.get('{{url('/api/total-patient')}}', function (data) {
                console.log(data);
                $("#total_patient").text(data);
            });

            $.get('{{url('/api/todays-patient')}}', function (data) {
                console.log(data);
                $("#todays_patient").text(data);
            });

            $.get('{{url('/api/latest-patient')}}', function (data) {
                console.log(data);
                $("#patient_latest").text(data);
            });

            $.get('{{url('/api/latest-prescription')}}', function (data) {
                console.log(data);
                $("#countPrescription").text(" -(" + data.length + ")");
                $.each(data, function (key, data) {
                    $("#latestPrescription").append(
                        $("<tr>").append(
                            $("<td>", {text: data.patient.name}),
                            $("<td>", {text: data.created_at}),
                            $("<td>", {text: data.drugs.length + " Drugs"})
                        )
                    )
                });
            });

            $.get('{{url('/api/latest-appointment')}}', function (data) {
                console.log(data);
                $("#countAppointment").text(" -(" + data.length + ")");
                $.each(data, function (key, data) {
                    $("#latestAppointment").append(
                        $("<tr>").append(
                            $("<td>", {text: data.patient.name}),
                            $("<td>", {text: data.created_at}),
                            $("<td>", {text: data.user.name})
                        )
                    )
                });
            });

        });
    </script>
@endsection