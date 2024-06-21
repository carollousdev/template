<?php $this->load->view('element/header'); ?>
<div class="content">
    <div class="container-fluid">
        <?php echo form_open($path . '/' . $method); ?>
        <div class="row">
            <?= $form ?>
        </div>
        <div class="row">
            <div class="col-6 g-3">
                <button class="btn btn-primary" id="btn_submit" type="submit">Submit</button>
                <button class="btn btn-default" type="button" onclick="window.location = '<?= base_url($path) ?>';">Close</button>
            </div>
        </div>
        </form>
    </div>
</div>
<?php $this->load->view('element/footer'); ?>