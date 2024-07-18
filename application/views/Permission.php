<!DOCTYPE html>
<html lang="en">

<body>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Admin Permission</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <p>Check All <input type="checkbox" name="select-all" id="select-all" /></p>
                    <?php echo form_open($path . '/permission'); ?>
                    <input type="hidden" id="id" name="id" value="<?= $id ?>">
                    <input type="hidden" id="action" name="action" value="true">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="text-align: left;">Menu</th>
                                <th>C</th>
                                <th>R</th>
                                <th>U</th>
                                <th>D</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?= $result; ?>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-6 g-3">
                            <button class="btn btn-primary" id="btn_submit" type="submit">Submit</button>
                            <button class="btn btn-default" type="button" onclick="window.location = '<?= base_url($path) ?>';">Close</button>
                        </div>
                    </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <?php $this->load->view('element/footer'); ?>