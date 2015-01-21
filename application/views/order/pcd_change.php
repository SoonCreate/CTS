<?= render_form_header('order_pcd_change')?>
<div class="container-fluid userd">
    <?= render_form_open('order','pcd_change') ?>
    <?= render_form_dateTimeBox('plan_complete_date',true,false,null,true) ?>
    <?= render_form_hidden('id',v('id')) ?>
    <?= render_button_group() ?>
    <?= render_form_close() ?>
</div>
