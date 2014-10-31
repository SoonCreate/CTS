<?= render_form_header('function_create');?>
<div class="container-fluid userd">
    <?= render_form_open('functions','create') ?>
    <?= render_form_input('function_name',true);?>
    <?php $this->load->view('functions/_form') ;?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>



