<?= render_form_header('user_create')?>
<div class="container-fluid userd">
    <?= render_form_open('user','create')?>
    <?= render_form_input('username',true)?>
    <?php $this->load->view('user/_form') ;?>
    <?= render_button_group()?>
    <?= render_form_close() ?>
</div>

