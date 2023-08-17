<div id="edit-drug-type" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mt-0">Edit Drug Type</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="javascript:void(0)" method="post" id="updateTypeForm">
                            {{csrf_field()}}
                            <div class="form-group-custom">
                                <input id="input_drug_type" type="text" name="type" required="required"/>
                                <label class="control-label">Drug Type &nbsp;*</label><i class="bar"></i>
                            </div>
                            <div class="checkbox">
                                <input name="status" id="drug_type_status" type="checkbox">
                                <label for="drug_type_status">
                                    Active
                                </label>
                            </div>
                            <input type="submit" value="Submit" hidden>
                        </form>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" id="updateDrugType" class="btn btn-info waves-effect waves-light">Save changes  &nbsp; <i id="loading" style="display: none" class="fa fa-refresh fa-spin"></i></button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->

