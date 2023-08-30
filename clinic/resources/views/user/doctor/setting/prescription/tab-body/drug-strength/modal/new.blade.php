<div id="add-drug-strength" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mt-0">Add Drug Strength</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="javascript:void(0)" id="saveDrugStrength">
                            {{csrf_field()}}
                            <div class="form-group-custom">
                                <input type="text" name="strength" required="required"/>
                                <label class="control-label">Drug Strength &nbsp;*</label><i class="bar"></i>
                            </div>
                            <input type="submit" value="Submit" hidden>
                        </form>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" onclick="$('#saveDrugStrength').submit()" class="btn btn-info waves-effect waves-light">Save changes</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->