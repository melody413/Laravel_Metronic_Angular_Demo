<div id="add-drug-type" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mt-0">Add Drug Type</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="#" method="post" id="drugTypeForm">
                            {{csrf_field()}}
                            <div class="form-group-custom">
                                <input type="text" name="type" required="required"/>
                                <label class="control-label">Drug Type &nbsp;*</label><i class="bar"></i>
                            </div>
                            <input type="submit" value="Submit" hidden>
                        </form>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" id="saveDrugType" class="btn btn-info waves-effect waves-light">Save changes  &nbsp; <i id="loading" class="fa fa-refresh fa-spin"></i></button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->

