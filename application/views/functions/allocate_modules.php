<h1>分配到模块</h1>
<form id="allocate_modules" method="post" action="<?= _url('functions','allocate_modules')?>">
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
                <td><input type="checkbox" name="modules[]" id="m_<?= $o['id'] ?>" value="<?= $o['id']?>" <?= $o['checked']?>/></td>
                <td><label for="m_<?= $o['id'] ?>"><?= $o['module_name'] ?></label></td>
                <td><?= $o['description'] ?></td>
                <td><?= $o['creation_date']?></td>
<!--                <td>--><?//= $o['sort']?><!--</td>-->
            </tr>
        <?php endforeach;?>
    </table>

    <input name="id" id="id" type="hidden" value="<?= v('id')?>" />
    <button type="submit">提交</button>
</form>
