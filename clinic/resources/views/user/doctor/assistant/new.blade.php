@extends('layouts.app')

@section('title')
    Create new assistant
@endsection

@section('extra-css')

@endsection

@section('breadcrumb')
    <li class="float-left">
        <a href="{{url('/')}}" class="">Home</a>&nbsp;/&nbsp;
    </li>
    <li class="float-left">
        Assistant / &nbsp;
    </li>
    <li class="float-left">
        <a href="{{url('/new-assistant')}}" class="">New Assistant</a>
    </li>
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header card-header-icon">
                <i class="fa fa-user-circle-o fa-2x"></i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Add new assistant</h4>
                <form action="#" method="post" id="newAssistant" enctype="multipart/form-data">
                    {{csrf_field()}}

                    <div class="row">
                        <div class="col-md-4" style="padding-left: 81px;">
                            <div id="image-preview">
                                <label for="image-upload" id="image-label">Assistant photo</label>
                                <input type="file" name="image" id="image-upload" />
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group-custom">
                                <input type="text" name="name"  required="required" autofocus/>
                                <label class="control-label">Name &nbsp;*</label><i class="bar"></i>
                            </div>
                            <div class="form-group-custom">
                                <input type="email" name="email" required="required"/>
                                <label class="control-label">Email &nbsp;*</label><i class="bar"></i>
                            </div>
                            <div class="form-group-custom">
                                <input type="password" name="password" id="pass1" required="required"/>
                                <label class="control-label">Password &nbsp;*</label><i class="bar"></i>
                            </div>
                            <div class="form-group-custom">
                                <input type="password" data-parsley-equalto="#pass1" name="confirm_password" required="required"/>
                                <label class="control-label">Confirm Password &nbsp;*</label><i class="bar"></i>
                            </div>
                            <div class="form-group-custom">
                                <input type="text" name="phone" required="required"/>
                                <label class="control-label">Phone &nbsp;*</label><i class="bar"></i>
                            </div>
                            <div class="form-group-custom">
                                <textarea name="address" required="required"></textarea>
                                <label class="control-label">Address</label><i class="bar"></i>
                            </div>
                        </div>
                    </div>

                   <div style="padding-left: 35%;">
                       <button type="submit" class="btn btn-primary waves-effect waves-light">Submit &nbsp; <i id="loading" class="fa fa-refresh fa-spin"></i></button>
                       <button type="reset" class="btn btn-danger waves-effect waves-light">Cancel</button>
                   </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('extra-js')
    <script>
        $(document).ready(function () {

            var form = $("#newAssistant");
            form.on('submit',function (e) {
               e.preventDefault();
               data = new FormData(this);
               $(this).speedPost('{{url('/save-assistant')}}',data,form);
            });
        })
    </script>
@endsection