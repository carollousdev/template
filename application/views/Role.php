<?php $this->load->view('element/header'); ?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <a href="<?= $path ?>/create" class="mt-1 btn btn-outline-primary btn-sm">Create <?= ucfirst($path) ?></a>
                <table id="myTable" class="table table-hover" style="width:100%;">
                    <?= $hTable ?>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('element/footer'); ?>