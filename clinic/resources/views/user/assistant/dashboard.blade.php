<div class="col-md-12">
    <h1 class="text-center">WELCOME BACK</h1>
    <div class="row">
        <div class="col-md-6 col-lg-6 col-xl-6">
            <div class="widget-panel widget-style-2 bg-white">
                <i class="ti-calendar text-primary"></i>
                <h2 class="m-0 text-dark counter font-600">
                   {{count(\App\Model\PatientAppointment::where('user_id',auth()->user()->id)->whereDate('created_at',\Carbon\Carbon::today())->get())}}
                </h2>
                <div class="text-muted m-t-5">Today's Appointment</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-6">
            <div class="widget-panel widget-style-2 bg-white">
                <i class="ti-notepad text-pink"></i>
                <h2 class="m-0 text-dark counter font-600">
                    {{count(\App\Model\PatientAppointment::where('user_id',auth()->user()->id)->get())}}
                </h2>
                <div class="text-muted m-t-5">Total Appointment</div>
            </div>
        </div>
    </div>
</div>