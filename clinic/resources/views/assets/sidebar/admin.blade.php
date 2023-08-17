<!-- ========== Left Sidebar Start ========== -->

<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>

                <li class="text-muted menu-title">Navigation</li>

                <li class="">
                    <a href="{{url('/home')}}" class="waves-effect"><i class="ti-home"></i> <span> {!! trans('menus.dash') !!} </span></a>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="ti-wheelchair"></i> <span> {!! trans('menus.patient.main_menu') !!} </span> <span class="menu-arrow"></span> </a>
                    <ul class="list-unstyled">
                        <li><a href="{{url('/new-patient')}}">{!! trans('menus.patient.new_patient_menu') !!}</a></li>
                        <li><a href="{{url('/all-patient')}}">{!! trans('menus.patient.all_patient_menu') !!}</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="ti-notepad"></i> <span> {!! trans('menus.prescription.main_menu') !!} </span> <span class="menu-arrow"></span> </a>
                    <ul class="list-unstyled">
                        <li><a href="{{url('/new-prescription')}}">{!! trans('menus.prescription.new_prescription_menu') !!}</a></li>
                        <li><a href="{{url('/all-prescription')}}">{!! trans('menus.prescription.all_prescription_menu') !!}</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="ti-calendar"></i> <span> {!! trans('menus.appointment.main_menu') !!} </span> <span class="menu-arrow"></span> </a>
                    <ul class="list-unstyled">
                        <li><a href="{{url('/new-appointment')}}">New Appointment</a></li>
                        <li><a href="{{url('/all-appointment')}}">All Appointment</a></li>
                        <li><a href="{{url('/appointment-today')}}">Appointment Today</a></li>
                    </ul>
                </li>

                {{-- <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="ti-user"></i> <span> {!! trans('menus.assistant.main_menu') !!} </span> <span class="menu-arrow"></span> </a>
                    <ul class="list-unstyled">
                        <li><a href="{{url('/new-assistant')}}">New Assistant</a></li>
                        <li><a href="{{url('/all-assistant')}}">All Assistant</a></li>
                    </ul>
                </li>
 --}}
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect {{Request::is('edit-template/*')  ? 'active' : ''}} {{Request::is('view-template/*')  ? 'active' : ''}}"><i class="ti-layout"></i> <span> {!! trans('menus.template.main_menu') !!} </span> <span class="menu-arrow"></span> </a>
                    <ul class="list-unstyled">
                        <li><a href="{{url('/new-template')}}">New Template</a></li>
                        <li><a href="{{url('/all-template')}}">All Template</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect {{Request::is('edit-drug/*') ? 'active' :''}}"><i class="icon icon-pill-small"></i> <span> {!! trans('menus.drug.main_menu') !!} </span> <span class="menu-arrow"></span> </a>
                    <ul class="list-unstyled">
                        {{-- <li><a href="{{url('/new-drug')}}">Add new drug</a></li> --}}
                        <li><a href="{{url('/all-drug')}}">All Drug</a></li>
                    </ul>
                </li>

                <?php $date_today = \Carbon\Carbon::today()->addDay(1)->toDateString();?>

                <li class="has_sub">    
                    <a href="javascript:void(0);"
                       class="waves-effect {{Request::is('/schedule-report/schedule=*/start=*/end=*') ? 'active' : ''}}">
                        <i class="ti-pie-chart"></i> <span> {!! trans('menus.report.main_menu') !!} </span> <span class="menu-arrow"></span> </a>
                    <ul class="list-unstyled">
                        <li><a href="{{url('/drug-report/drug=0/start=2017-06-05/end='.$date_today)}}">Drug Report</a></li>
                        <li><a href="{{url('/template-report/template=0/start=2017-06-05/end='.$date_today)}}">Template Report</a></li>
                        <li><a href="{{url('/schedule-report/schedule=0/start=2017-06-05/end='.$date_today)}}">Schedule Report</a></li>
                    </ul>
                </li>



                <li class="text-muted menu-title">Settings</li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="ti-settings"></i> <span> {!! trans('menus.setting.main_menu') !!} </span> <span class="menu-arrow"></span> </a>
                    <ul class="list-unstyled">
                        <li><a href="{{url('/all-schedule')}}">Schedule Setting</a></li>
                        {{-- <li><a href="{{url('/prescription-setting')}}">Prescription Setting</a></li> --}}
                        <li><a href="{{url('/app-setting')}}">App Setting</a></li>
                        <li><a href="{{url('/profile')}}">Profile</a></li>
                    </ul>
                </li>


            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- Left Sidebar End -->