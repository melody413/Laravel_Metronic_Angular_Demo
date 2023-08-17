<div id="change-password" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mt-0">Change Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="passwordChangeForm">
                    {{csrf_field()}}
                    <div class="form-group-custom">
                        <input type="password" name="password" required="required" autofocus/>
                        <label class="control-label">Current Password &nbsp;*</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        <input type="password" name="new_password" required="required" autofocus/>
                        <label class="control-label">New Password &nbsp;*</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        <input type="password" name="confirm" required="required" autofocus/>
                        <label class="control-label">Re-Type Password &nbsp;*</label><i class="bar"></i>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" onclick="$('#passwordChangeForm').submit()" class="btn btn-info waves-effect waves-light">Save changes</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->