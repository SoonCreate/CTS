<table>
    <thead>
        <th>object_id</th>
        <th>权限对象名</th>
        <th>描述</th>
        <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
    <tr>
        <td><?= $o['id']?></td>
        <td><?= $o['object_name']?></td>
        <td><?= $o['description']?></td>

        <td><a href="<?= _url('auth_object','edit',array('id'=>$o['id']))?>">编辑</a>&nbsp;|&nbsp;
            <a href="<?= _url('auth_object','destroy',array('id'=>$o['id']))?>">删除</a>&nbsp;|&nbsp;
            <a href="<?= _url('auth_object','items',array('id'=>$o['id']))?>">权限对象项目</a>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<a href="<?= _url('auth_object','create')?>">新建权限对象</a>