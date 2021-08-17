<div class="modal fade" id="check-list-creator-modal" tabindex="-1" role="dialog" aria-labelledby="check-list-creator-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="check-list-creator-modal-label">Create New Check List</h4>
            </div>
            <div class="modal-body">

              <div id="error_checklist_creator" class="alert alert-danger" role="alert">
                <span id="error_msg_checklist_creator"></span>
              </div>

                <form id="frm_checklist_creator" name="frm_checklist_creator" class="form-horizontal" novalidate="">
                  {{ csrf_field() }}

                    <div class="form-group error">
                        <label class="col-sm-3 control-label">Name</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="new_checklist_name" name="new_checklist_name" required></textarea>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-checklist-creator-save" value="add">Save Checklist</button>
            </div>
        </div>
    </div>
</div>