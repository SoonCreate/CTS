<table>
    <thead>
        <th>Role_id</th>
        <th>角色名</th>
        <th>描述</th>
        <th>操作</th>
    </thead>
    <?php foreach($roles as $o):?>
    <tr>
        <td><?= $o['id']?></td>
        <td><?= $o['role_name']?></td>
        <td><?= $o['description']?></td>

        <td><a href="<?= _url('role','edit',array('id'=>$o['id']))?>">编辑</a>&nbsp;|&nbsp;
            <a href="<?= _url('role','destroy',array('id'=>$o['id']))?>">删除</a> &nbsp;|&nbsp;
            <a href="<?= _url('role','allocate_users',array('role_id'=>$o['id']))?>">分配到用户</a>&nbsp;|&nbsp;
            <a href="<?= _url('role','choose_functions',array('role_id'=>$o['id']))?>">功能模块管理</a>&nbsp;|&nbsp;
            <a href="<?= _url('role','profiles',array('role_id'=>$o['id']))?>">权限对象管理</a>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<a href="<?= _url('role','create')?>">新建角色</a>&nbsp;|&nbsp;
<a href="<?= _url('role','copy_from')?>" title="以拷贝的方式创建">拷贝</a>