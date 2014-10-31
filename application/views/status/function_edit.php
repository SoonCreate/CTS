<?= render_form_header('function_edit');?>
<div class="container-fluid userd">
    <?= render_form_open('status','function_edit') ?>
    <?php $this->load->view('status/_function_form') ?>
    <?= render_form_hidden('id');?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>