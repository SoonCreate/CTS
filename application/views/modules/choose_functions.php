<h1>功能选择</h1>
<form id="choose_functions" method="post" action="<?= _url('modules','choose_functions')?>">
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
                <td><input type="checkbox" name="functions[]" id="fn_<?= $o['id'] ?>" value="<?= $o['id']?>" <?= $o['checked']?>/></td>
                <td><label for="fn_<?= $o['id'] ?>"><?= $o['function_name'] ?></label></td>
                <td><?= $o['description'] ?></td>
                <td><?= $o['creation_date']?></td>
<!--                <td>--><?//= $o['sort']?><!--</td>-->
            </tr>
        <?php endforeach;?>
    </table>

    <input name="module_id" id="module_id" type="hidden" value="<?= _v('module_id')?>" />
    <button type="submit">提交</button>
</form>
