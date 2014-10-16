<?= render_form_open('valuelist','edit') ?>
<?= render_form_header('valuelist_edit');?>
<?= render_form_input('valuelist_name',null,array(),TRUE);?>
<?php $this->load->view('valuelist/_form');?>
<?= render_form_hidden('id',v('id'));?>
<?= render_button_group();?>
<?= render_form_close() ?>
