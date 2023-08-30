@extends('layouts.app')

@section('title')
    Edit Profile
@endsection

@section('extra-css')

@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header card-header-icon">
                <i class="fa fa-user-circle-o fa-2x"></i>
            </div>
            <div class="card-content">
                <h4 class="card-title">{{auth()->user()->name}}</h4>
                <form action="#" method="post" id="updateProfile" enctype="multipart/form-data">
                    {{csrf_field()}}

                    <div class="row">
                        <div class="col-md-4" style="padding-left: 81px;">
                            <div id="image-preview" style="background-image: url('{{url(auth()->user()->image ? auth()->user()->image : '/dashboard/images/image_placeholder.jpg')}}')">
                                <label for="image-upload" id="image-label">Profile Pic</label>
                                <input type="file" name="image" id="image-upload" />
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group-custom">
                                <input type="text" name="name" value="{{auth()->user()->name}}" required="required" autofocus/>
                                <label class="control-label">Name &nbsp;*</label><i class="bar"></i>
                            </div>
                            <div class="form-group-custom">
                                <input type="email" name="email" value="{{auth()->user()->email}}" required="required"/>
                                <label class="control-label">Email &nbsp;*</label><i class="bar"></i>
                            </div>

                            <div class="form-group-custom">
                                <input type="text" value="{{auth()->user()->phone}}" name="phone" required="required"/>
                                <label class="control-label">Phone &nbsp;*</label><i class="bar"></i>
                            </div>
                            @if(auth()->user()->role == 1)
                                <div class="form-group-custom">
                                    <textarea name="info" required="required" rows="4">{{auth()->user()->info}}</textarea>
                                    <label class="control-label">Info</label><i class="bar"></i>
                                </div>
                            @endif

                            <div class="form-group-custom">
                                <textarea name="address" required="required">{{auth()->user()->address}}</textarea>
                                <label class="control-label">Address</label><i class="bar"></i>
                            </div>

                        </div>
                    </div>

                    <div style="padding-left: 35%;">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Update &nbsp; <i id="loading" class="fa fa-refresh fa-spin"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    <script>
        $(document).ready(function () {
            $("#updateProfile").on('submit',function (e) {
                e.preventDefault();
                var data = new FormData(this);
                console.log('submit');
                $(this).speedPost('{{url('/update-profile')}}',data);
            })
        })
    </script>
@endsection