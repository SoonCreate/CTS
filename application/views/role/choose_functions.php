<h1>功能选择</h1>
<form id="choose_functions" method="post" action="<?= _url('role','choose_functions')?>">
    <table>
        <thead>
        <th>选择</th>
        <th>所属模块</th>
        <th>模块描述</th>
        <th>功能名</th>
        <th>功能描述</th>
        </thead>
        <?php foreach($objects as $o) :?>
            <tr>
                <td><input type="checkbox" name="lines[]" id="fn_<?= $o['id'] ?>" value="<?= $o['id']?>" <?= $o['checked']?>/></td>
                <td><label for="fn_<?= $o['id'] ?>"><?= $o['module_name'] ?></label></td>
                <td><?= $o['module_desc'] ?></td>
                <td><?= $o['function_name']?></td>
                <td><?= $o['function_desc']?></td>
            </tr>
        <?php endforeach;?>
    </table>

    <input name="role_id" id="role_id" type="hidden" value="<?= _v('role_id')?>" />
    <button type="submit">提交</button>
</form>
