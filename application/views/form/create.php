<?= render_form_header('form_create');?>
<div class="container-fluid userd">
    <?= render_form_open('form','create') ?>
    <?= render_form_input('form_name',true)?>
    <?php $this->load->view('form/_form');?>
    <?= render_form_close() ?>
</div>