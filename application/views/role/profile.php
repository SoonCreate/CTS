<h1>权限对象管理</h1>
<a href="<?= _url('role','profile_add_object',array('role_id'=>_v('role_id')))?>">添加权限对象</a>

<table>
    <thead>
    <th>profile_id</th>
    <th>权限对象</th>
    <th>权限对象描述</th>
    <th>操作</th>
    </thead>
    <?php foreach($objects as $o) :?>
        <tr>
            <td><?= $o['id'] ?></td>
            <td><?= $o['object_name'] ?></td>
            <td><?= $o['object_desc'] ?></td>
            <td><a href="<?= _url('role','profile_object_items',array('id'=>$o['id']))?>">项目管理</a>&nbsp;|&nbsp;
                <a href="<?= _url('role','profile_destroy',array('id'=>$o['id']))?>">删除</a> </td>
        </tr>
    <?php endforeach;?>
</table>

<input name="role_id" id="role_id" type="hidden" value="<?= v('role_id')?>" />

