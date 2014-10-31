<?= render_form_header('function_create');?>
<div class="container-fluid userd">
    <?= render_form_open('status','function_create') ?>
    <?php $this->load->view('status/_function_form') ?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>
