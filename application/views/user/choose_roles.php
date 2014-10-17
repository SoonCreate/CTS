<?= render_form_header('choose_roles');?>
<?= render_form_open('user','choose_roles') ?>
    <?php foreach($roles as $role) :?>
        <?= render_single_checkbox('roles[]',$role['id'], $role['description'] ,$role['checked'],'role_'.$role['id'])?>
    <?php endforeach;?>
<?= render_form_hidden('id',v('id'));?>
<?= render_button_group();?>
<?= render_form_close() ?>
