<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mt-0">Add New Drug</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="newDrug">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-custom">
                                <input type="text" name="name" required="required"/>
                                <label class="control-label">Trade Nmae</label><i class="bar"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-custom">
                                <input type="text" name="generic_name" required="required"/>
                                <label class="control-label">Generic Name</label><i class="bar"></i>
                            </div>
                        </div>
                    </div>
                    <button type="submit" hidden></button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" id="saveDrug" class="btn btn-info waves-effect waves-light">Save changes</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->
