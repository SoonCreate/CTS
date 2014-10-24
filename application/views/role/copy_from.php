<?= render_form_header('role_copy') ?>
<div class="container-fluid userd">
    <?= render_form_open('role','copy_from') ?>
    <?= render_select_with_options('role_from','vl_roles',TRUE);?>
    <?= render_form_input('role_name',TRUE);?>
    <?= render_form_input('description',TRUE);?>
    <?= render_button_group();?>
    <?= render_form_close() ?>
</div>