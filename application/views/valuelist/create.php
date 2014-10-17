<?= render_form_open('valuelist','create') ?>
<?= render_form_header('valuelist_create');?>
<?= render_form_input('valuelist_name',true);?>
    <?php $this->load->view('valuelist/_form');?>
<?= render_button_group();?>
<?= render_form_close() ?>