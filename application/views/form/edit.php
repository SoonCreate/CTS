<?= render_form_header('form_create');?>
<div class="container-fluid userd">
    <?= render_form_open('form','edit') ?>
    <?= render_form_input('form_name',true,true)?>
    <?php $this->load->view('form/_form');?>
    <?= render_form_hidden('id')?>
    <?= render_form_close() ?>
</div>