<?= render_form_open('order','choose_leader') ?>
<?= render_form_header('order_choose_leader');?>
<?= render_select_add_options('leader_id',render_options_by_array(_v('leader_id')),true)?>
<?= render_form_hidden('id',v('id'))?>
<?= render_button_group();?>
<?= render_form_close() ?>
