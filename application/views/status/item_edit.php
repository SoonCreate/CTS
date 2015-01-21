<?= render_form_header('item_edit');?>
<div class="container-fluid userd">
    <?= render_form_open('status','item_edit') ?>
    <?= render_form_input('step',false,true) ?>
    <?php $this->load->view('status/_item_form') ?>
    <?= render_form_hidden('id',v('id'));?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>
