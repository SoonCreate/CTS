<?= render_form_header('log_type_create');?>
<div class="container-fluid userd">
    <?= render_form_open('order_log_type','create') ?>
    <?= render_form_input('log_type',true)?>
    <?php $this->load->view('order_log_type/_form');?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>
