<?= render_form_header('log_type_edit');?>
<div class="container-fluid userd">
    <?= render_form_open('order_log_type','edit') ?>
    <?= render_form_input('log_type',false,true);?>
    <?php $this->load->view('order_log_type/_form');?>
    <?= render_form_hidden('id',v('id'));?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>

