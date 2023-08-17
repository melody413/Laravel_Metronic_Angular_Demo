<h4 class="card-title">Add new patient</h4>
<form action="#" method="post" id="newPatient" enctype="multipart/form-data">
    {{csrf_field()}}
    <div class="row">
        <div class="col-md-4">
           <center>
               <div id="image-preview">
                   <label for="image-upload" id="image-label">Patient photo</label>
                   <input type="file" name="image" id="image-upload" />
               </div>
           </center>
        </div>
        <div class="col-md-8">
            <div class="form-group-custom">
                <input type="text" name="name" required="required" autofocus/>
                <label class="control-label">Name &nbsp;<span class="text-danger">*</span></label><i class="bar"></i>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-custom">
                        <select name="gender" id="" required="required">
                            <option value="1">Male</option>
                            <option value="2">Fe-male</option>
                            <option value="3">Other</option>
                        </select>
                        <label class="control-label">Gender &nbsp;<span class="text-danger">*</span></label><i class="bar"></i>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-custom">
                        <input type="date" name="date_of_birth" id="datepicker-autoclose" required="required" />
                        <label class="control-label">Date of birth &nbsp;<span class="text-danger">*</span></label><i class="bar"></i>
                    </div>
                </div>
            </div>
            <div class="form-group-custom">
                <input type="text" name="phone"  required="required"/>
                <label class="control-label">Phone &nbsp;<span class="text-danger">*</span></label><i class="bar"></i>
            </div>
            <div class="form-group-custom">
                <input type="text" name="email" />
                <label class="control-label">Email</label><i class="bar"></i>
            </div>
            <div class="form-group-custom">
                <textarea name="address"></textarea>
                <label class="control-label">Address &nbsp;</label><i class="bar"></i>
            </div>

        </div>
    </div>

    <div style="padding-left: 35%;">
        <button type="submit" class="btn btn-primary waves-effect waves-light">Submit &nbsp; <i id="loading" class="fa fa-refresh fa-spin"></i></button>
        <button type="reset" class="btn btn-danger waves-effect waves-light">Cancel</button>
    </div>

</form>