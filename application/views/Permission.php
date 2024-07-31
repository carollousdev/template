<?php $this->load->view('element/header'); ?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <p>Check All <input type="checkbox" name="select-all" id="select-all" /></p>
                <?php echo form_open($path . '/permission'); ?>
                <input type="hidden" id="id" name="id" value="<?= $id ?>">
                <input type="hidden" id="action" name="action" value="true">
                <table class="table table-bordered table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th style="text-align: left;">Menu</th>
                            <th>C</th>
                            <th>R</th>
                            <th>U</th>
                            <th>D</th>
                            <th>COPY</th>
                            <th>CSV</th>
                            <th>EXCEL</th>
                            <th>PDF</th>
                            <th>PRINT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $result; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-6 mb-3">
                <button class="btn btn-primary" id="btn_submit" type="submit">Submit</button>
                <button class="btn btn-default" type="button" onclick="window.location = '<?= base_url($path) ?>';">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>

<?php $this->load->view('element/footer'); ?>