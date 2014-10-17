<?= render_form_header('allocate_modules');?>
<?= render_form_open('functions','allocate_modules') ?>
    <table>
        <thead>
        <th>选择</th>
        <th>模块名</th>
        <th>模块描述</th>
        <th>注册时间</th>
        <th>排序</th>
        </thead>
        <?php foreach($modules as $o) :?>
            <tr>
                <td><input  type="checkbox" name="modules[]" id="m_<?= $o['id'] ?>" value="<?= $o['id']?>" <?= $o['checked']?>/></td>
                <td><label for="m_<?= $o['id'] ?>"><?= $o['module_name'] ?></label></td>
                <td><?= $o['description'] ?></td>
                <td><?= $o['creation_date']?></td>
<!--                <td>--><?//= $o['sort']?><!--</td>-->
            </tr>
        <?php endforeach;?>
    </table>

<?= render_form_hidden('id',v('id'));?>
<?= render_button_group();?>
<?= render_form_close() ?>