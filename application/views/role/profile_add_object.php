<?= render_form_open('role','profile_add_object') ?>
<?= render_form_header('add_object');?>
    <label for="object_id">*请选择权限对象</label>
    <select id="object_id" name="object_id">
        <?php foreach($objects as $o) :?>
            <option value="<?= $o['id']?>"><?= $o['object_name'].' - '.$o['description']?></option>
        <?php endforeach;?>
    </select>
<?= render_form_hidden('role_id',v('role_id'));?>
<?= render_button_group();?>
<?= render_form_close() ?>