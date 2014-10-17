<?= render_form_header('choose_functions');?>
<?= render_form_open('modules','choose_functions') ?>
    <table>
        <thead>
        <th>选择</th>
        <th>功能名</th>
        <th>功能描述</th>
        <th>注册时间</th>
        <th>排序</th>
        </thead>
        <?php foreach($functions as $o) :?>
            <tr>
                <td>
                    <input data-dojo-type="sckj/form/CheckBox"  type="checkbox" name="functions[]"
                           id="fn_<?= $o['id'] ?>" value="<?= $o['id']?>" <?= $o['checked']?>/>
                </td>
                <td><label for="fn_<?= $o['id'] ?>"><?= $o['function_name'] ?></label></td>
                <td><?= $o['description'] ?></td>
                <td><?= $o['creation_date']?></td>
<!--                <td>--><?//= $o['sort']?><!--</td>-->
            </tr>
        <?php endforeach;?>
    </table>
<?= render_form_hidden('module_id',v('module_id'));?>
<?= render_button_group();?>
<?= render_form_close() ?>