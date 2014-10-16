<div class="row paneltitle">
    <?= render_form_header('change_password');?>
</div>
<div class="container-fluid userd">
<?= render_form_open('user','change_password');?>
<?= render_form_password('old_password',TRUE);?>
<?= render_form_password('new_password',TRUE);?>
<?= render_form_password('re_new_password',TRUE);?>
<?= render_button_group();?>
<?= render_form_close() ?>
</div>