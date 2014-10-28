<?= render_form_header('notice_rule_create');?>
<div class="container-fluid userd">
    <?= render_form_open('order_log_type','notice_rule_create') ?>
    <?php $this->load->view('order_log_type/_notice_rule_form') ?>
    <?= render_form_hidden('log_type_id',v('log_type_id'))?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>
