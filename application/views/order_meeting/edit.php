<?= render_form_open('order_meeting','edit') ?>
<?= render_form_header('meeting_edit');?>
<?php $this->load->view('order_meeting/_form');?>
<?= render_form_hidden('id',_v('id'))?>
<?= render_button_group();?>
<?= render_form_close() ?>

