<?= render_form_header('order_dispatcher');?>
<div class="container-fluid userd">
    <?= render_form_open('order','dispatcher','null','null','goback') ?>
    <?= render_select_add_options('manager_id',render_options_by_array(_v('managers')),true)?>
    <?= render_form_hidden('id',v('id'))?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>
