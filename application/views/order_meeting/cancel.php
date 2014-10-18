<?= render_form_open('order_meeting','cancel') ?>
<?= render_form_header('meeting_cancel');?>
<?= render_select_with_options('cancel_reason','vl_meeting_cancel',true)?>
<?= render_form_textarea('cancel_remark')?>
<?= render_form_hidden('id')?>
<?= render_button_group();?>
<?= render_form_close() ?>
