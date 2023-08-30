<!--  Modal content for the above example -->
<div id="about-me" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mt-0">About me <small>This content will show in website</small> </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="saveAboutMe">
                    {{csrf_field()}}
                    <div class="form-group-custom">
                        <textarea name="about" id="" cols="30" rows="5" required="required">{{\App\Model\About::first() ? \App\Model\About::first()->about : ""}}</textarea>
                        <label class="control-label">About Me &nbsp;*</label><i class="bar"></i>
                    </div>
                    <button class="btn btn-success">Submit</button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
