<?= render_form_header('notice_rule_edit');?>
<div class="container-fluid userd">
    <?= render_form_open('order_log_type','notice_rule_edit') ?>
    <?= render_select_add_options('order_type',render_options('vl_order_type',null,true))?>
    <?= render_form_input('when_new_value');?>
    <?= render_form_input('when_old_value');?>
    <?= render_single_checkbox('notice_created_by',1,'通知到创建者')?>
    <?= render_single_checkbox('notice_manager',1,'通知到责任人')?>
    <?= render_single_checkbox('inactive_flag',1)?>
    <?= render_select_add_options('default_role_id',render_options('vl_roles',null,FALSE,true))?>
    <?= render_form_input('description')?>
    <?= render_form_hidden('id',v('id'))?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>