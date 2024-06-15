<?php $this->load->view('element/header'); ?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <button class="btn btn-sm btn-success mt-3 mb-2" id="btn_add" type="button">Add <?= ucfirst($path) ?></button>
                <table id="myTable" class="table table-bordered table-striped display">
                    <?= $hTable ?>
                </table>
            </div>
        </div>
        <div>
            <div class="modal fade" id="addModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add data <?= ucfirst($path) ?></h4>
                            <button class="close" data-dismiss="modal" type="button">×</button>
                        </div>
                        <div class="modal-body">
                            <form id="form-add" method="post">
                                <div id="form-field-add"></div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" id="btn_submit" type="button">Submit</button>
                            <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"> Edit Data <?= ucfirst($path) ?></h4>
                            <button class="close" data-dismiss="modal" type="button">×</button>
                        </div>
                        <div class="modal-body">
                            <form id="form-edit" method="post">
                                <div id="form-field-edit"></div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" id="btn_edit_submit" type="button">Submit</button>
                            <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('element/footer'); ?>