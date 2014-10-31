<?= render_form_header('function_edit');?>
<?= render_form_open('functions','edit') ?>
<div class="container-fluid userd">
    <?= render_form_input('function_name',null,array(),true);?>
    <?php $this->load->view('functions/_form') ;?>
    <?= render_form_hidden('id',v('id'));?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>