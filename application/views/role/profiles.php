<h1>权限对象管理</h1>
<a href="<?= _url('role','profile_add_object',array('role_id'=>_v('role_id')))?>">添加权限对象</a>

<table>
    <thead>
    <th>profile_id</th>
    <th>权限对象</th>
    <th>权限对象描述</th>
    <th>项目名称</th>
    <th>项目描述</th>
    <th>项目值</th>
    </thead>
    <?php foreach($objects as $o) :?>
        <tr>
            <td><?= $o['profile_id'] ?></td>
            <td><?= $o['object_name'] ?></td>
            <td><?= $o['object_desc'] ?></td>
            <td><?= $o['auth_item_name'] ?></td>
            <td><?= $o['auth_item_desc'] ?></td>
            <td><?= $o['auth_value'] ?></td>
        </tr>
    <?php endforeach;?>
</table>

<input name="role_id" id="role_id" type="hidden" value="<?= _v('role_id')?>" />
<button type="submit">提交</button>

