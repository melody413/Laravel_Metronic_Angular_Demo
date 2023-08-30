@extends('layouts.app')

@section('title')
    Create new prescription template
@endsection

@section('extra-css')
    <link rel="stylesheet" href="{{url('/dashboard/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{url('/dashboard/plugins/jquery-ui/jquery-ui.css')}}">
@endsection

@section('content')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon">
                <i class="fa fa-file-o fa-2x"></i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Add new prescription template</h4>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group-custom">
                            <textarea required="required" id="cc" rows="3"></textarea>
                            <label class="control-label">Chief Complains</label><i class="bar"></i>
                        </div>
                        <div class="form-group-custom">
                            <textarea required="required" id="oe" rows="3"></textarea>
                            <label class="control-label">On examinations</label><i class="bar"></i>
                        </div>
                        <div class="form-group-custom">
                            <textarea required="required" id="pd" rows="3"></textarea>
                            <label class="control-label">Provisional Diagnosis</label><i class="bar"></i>
                        </div>
                        <div class="form-group-custom">
                            <textarea required="required" id="dd" rows="3"></textarea>
                            <label class="control-label">Differential diagnosis</label><i class="bar"></i>
                        </div>
                        <div class="form-group-custom">
                            <textarea required="required" id="lab_worekup" rows="3"></textarea>
                            <label class="control-label">Lab Workup</label><i class="bar"></i>
                        </div>
                        <div class="form-group-custom">
                            <textarea id="advice" required="required"></textarea>
                            <label class="control-label">Advices</label><i class="bar"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4>Rx</h4>
                        <form action="javascript:void(0)" method="post" id="addDrugToListForm">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group-custom">
                                    <input type="text" id="drug_type" placeholder="Type" />
                                    <label class="control-label"></label><i class="bar"></i>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control select2" id="drug">
                                    <option></option>
                                    @foreach($drugs as $drug)
                                        <option value="{{$drug->id}}">{{$drug->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-block btn-default waves-effect waves-light" data-toggle="modal"
                                        data-target="#con-close-modal" id="btnNewDrug">+
                                </button>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group-custom">
                                    <input type="text" id="strength" />
                                    <label class="control-label">Strength</label><i class="bar"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <input type="text" id="dose" />
                                    <label class="control-label">Dose</label><i class="bar"></i>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <input type="text"  id="duration" />
                                    <label class="control-label">Duration</label><i class="bar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group-custom">
                                    <input type="text" id="drug_advice"/>
                                    <label class="control-label">Advice</label><i class="bar"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="submit"  class="btn btn-success waves-effect" data-dismiss="modal">Add Drug in prescription</button>
                        </div>
                        </form>

                        <hr>
                        <ol id="drugListView">
                            {{--<li>Napa 25mg &nbsp; &emsp;--}}
                                {{--<a href="javascript:void(0)" class="btn btn-link btn-sm"><i class="fa fa-pencil"></i></a>--}}
                                {{--<a href="javascript:void(0)" class="btn btn-link btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>--}}
                                {{--<ul>--}}
                                    {{--<li>1+1+1 7Days</li>--}}
                                    {{--<li>Advice</li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                        </ol>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group-custom">
                            <input type="text" id="templateName" required="required"/>
                            <label class="control-label">Template Name</label><i class="bar"></i>
                        </div>
                        <div class="form-group-custom">
                            <textarea id="note" required="required"></textarea>
                            <label class="control-label">Note</label><i class="bar"></i>
                        </div>
                    </div>
                </div>
            </div>


            <button type="button" id="saveTemplate" class="btn btn-block btn-lg btn-primary waves-effect waves-light">Save Template</button>

        </div>
    </div>


    @include('user.doctor.template.modals.new-drug')
    @include('user.doctor.template.modals.edit-drug-from-list')
@endsection

@section('extra-js')
    <script src="{{url('/dashboard/js/jquery.hotkeys-0.7.9.min.js')}}"></script>
    <script src="{{url('/dashboard/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{url('/app_js/prescription-template.js')}}"></script>
    <script src="{{url('/dashboard/plugins/jquery-ui/jquery-ui.js')}}"></script>
    <script src="{{url('/app_js/prescription-autocomplete.js')}}"></script>
@endsection