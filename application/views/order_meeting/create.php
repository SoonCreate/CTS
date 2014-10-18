<?= render_form_open('order_meeting','create') ?>
<?= render_form_header('meeting_create');?>
<?php $this->load->view('order_meeting/_form');?>
<?= render_button_group();?>
<?= render_form_close() ?>
