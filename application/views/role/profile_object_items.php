<table>
    <thead>
    <th>项目id</th>
    <th>权限对象</th>
    <th>权限对象描述</th>
    <th>项目名称</th>
    <th>项目描述</th>
    <th>项目值</th>
    <th>操作</th>
    </thead>
    <?php foreach($objects as $o) :?>
        <tr>
            <td><?= $o['id'] ?></td>
            <td><?= $o['object_name'] ?></td>
            <td><?= $o['object_desc'] ?></td>
            <td><?= $o['auth_item_name'] ?></td>
            <td><?= $o['auth_item_desc'] ?></td>
            <td><?= $o['auth_value'] ?></td>
            <td><a href="<?= _url('role','profile_object_item_edit',array('id'=>$o['id']))?>">编辑</a></td>
        </tr>
    <?php endforeach;?>
</table>
