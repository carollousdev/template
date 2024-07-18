<?php $this->load->view('element/header'); ?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <?= $create_permission ?>
                <table id="myTable" class="table table-hover" style="width:100%;">
                    <?= $hTable ?>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('element/footer'); ?>