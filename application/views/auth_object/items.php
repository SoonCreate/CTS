<table>
    <thead>
        <th>项目名</th>
        <th>项目描述</th>
        <th>默认值</th>
        <th>操作</th>
    </thead>
    <?php foreach($items as $o):?>
    <tr>
        <td><?= $o['auth_item_name']?></td>
        <td><?= $o['auth_item_desc']?></td>
        <td><?= $o['default_value']?></td>

        <td><a href="<?= _url('auth_object','item_edit',array('item_id'=>$o['id']))?>">编辑</a>&nbsp;|&nbsp;
            <a href="<?= _url('auth_object','item_destroy',array('item_id'=>$o['id']))?>">删除</a>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<a href="<?= _url('auth_object','item_create')?>">插入新项目</a>