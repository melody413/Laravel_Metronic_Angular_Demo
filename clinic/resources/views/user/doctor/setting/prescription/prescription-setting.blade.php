@extends('layouts.app')

@section('title')
    Prescription Setting
@endsection

@section('extra-css')
    <link rel="stylesheet" href="{{url('/dashboard/plugins/datatables/datatable.min.css')}}">
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header card-header-icon">
                <i class="icon icon-pill"></i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Prescription Setting</h4>
                <ul class="nav nav-tabs tabs">
                    <li class="tab">
                        <a href="ui-tabs.html#drug-type" data-toggle="tab" aria-expanded="false">
                            Drug Types
                        </a>
                    </li>
                    <li class="tab">
                        <a href="ui-tabs.html#drug-strength" data-toggle="tab" aria-expanded="false">
                            Drug Strength
                        </a>
                    </li>
                    <li class="tab">
                        <a href="ui-tabs.html#drug-dose" data-toggle="tab" aria-expanded="true">
                            Dose
                        </a>
                    </li>
                    <li class="tab">
                        <a href="ui-tabs.html#duration" data-toggle="tab" aria-expanded="false">
                            Duration
                        </a>
                    </li>
                    <li class="tab">
                        <a href="ui-tabs.html#drug-advice" data-toggle="tab" aria-expanded="false">
                            Drug Advice
                        </a>
                    </li>
                    <li class="tab">
                        <a href="ui-tabs.html#advice" data-toggle="tab" aria-expanded="false">
                            Advice
                        </a>
                    </li>
                    <li class="tab">
                        <a href="ui-tabs.html#print-setup" data-toggle="tab" aria-expanded="false">
                            Print Setup
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    @include('user.doctor.setting.prescription.tab-body.drug-types.drug-types')
                    @include('user.doctor.setting.prescription.tab-body.drug-strength.drug-strength')
                    @include('user.doctor.setting.prescription.tab-body.drug-dose.drug-dose')
                    @include('user.doctor.setting.prescription.tab-body.drug-duration.drug-duration')
                    @include('user.doctor.setting.prescription.tab-body.drug-advice.drug-advice')
                    @include('user.doctor.setting.prescription.tab-body.advice.advice')
                    @include('user.doctor.setting.prescription.tab-body.print-setup')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    <script src="{{url('/dashboard/plugins/datatables/datatable.min.js')}}"></script>
    @include('user.doctor.setting.prescription.tab-body.drug-types.script')
    @include('user.doctor.setting.prescription.tab-body.drug-strength.script')
    @include('user.doctor.setting.prescription.tab-body.drug-dose.script')
    @include('user.doctor.setting.prescription.tab-body.drug-duration.script')
    @include('user.doctor.setting.prescription.tab-body.drug-advice.script')
    @include('user.doctor.setting.prescription.tab-body.advice.script')
    <script>
        $(document).ready(function () {
            $("#prescriptionPrintSetup").on('submit',function (e) {
                e.preventDefault();
                var data = new FormData(this);
                console.log('prescription print setup submit');
                $(this).speedPost('{{url('/prescription-print-setting')}}',data);
            })
        })
    </script>
@endsection