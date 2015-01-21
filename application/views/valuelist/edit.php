<?= render_form_header('valuelist_edit');?>
<div class="container-fluid userd">
    <?= render_form_open('valuelist','edit') ?>
    <?= render_form_input('valuelist_name',false,TRUE);?>
    <?php $this->load->view('valuelist/_form');?>
    <?= render_form_hidden('id',v('id'));?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>
