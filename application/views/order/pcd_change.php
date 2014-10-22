<?= render_form_header('order_pcd_change')?>
<div class="container-fluid userd">
    <?= render_form_open('order','pcd_change') ?>
    <?= render_form_datetextbox('plan_complete_date',TRUE,array(),false,render_form_timebox('plan_complete_time'));?>
    <?= render_form_hidden('id',v('id'))?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>
