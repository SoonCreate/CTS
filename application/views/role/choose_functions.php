<?= render_form_header('choose_functions');?>
<?= render_form_open('role','choose_functions') ?>
    <table class="table">
        <thead>
        <th>选择</th>
        <th>所属模块</th>
        <th>模块描述</th>
        <th>功能名</th>
        <th>功能描述</th>
        </thead>
        <?php foreach($objects as $o) :?>
            <tr>
                <td><input data-dojo-type="sckj/form/CheckBox" type="checkbox" name="lines[]" id="fn_<?= $o['id'] ?>" value="<?= $o['id']?>" <?= $o['checked']?>/></td>
                <td><label for="fn_<?= $o['id'] ?>"><?= $o['module_name'] ?></label></td>
                <td><?= $o['module_desc'] ?></td>
                <td><?= $o['function_name']?></td>
                <td><?= $o['function_desc']?></td>
            </tr>
        <?php endforeach;?>
    </table>

<?= render_form_hidden('role_id',v('role_id'));?>
<?= render_button_group();?>
<?= render_form_close() ?>
