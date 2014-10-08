<table>
    <thead>
        <th>值集ID</th>
        <th>值集名称</th>
        <th>描述</th>
        <th>来自表/视图</th>
        <th>说明字段</th>
        <th>值字段</th>
        <th>源表/视图</th>
        <th>查询条件</th>
        <th>父值集ID</th>
        <th>是否可编辑</th>
        <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
    <tr>
        <td><?= $o['id']?></td>
        <td><?= $o['valuelist_name']?></td>
        <td><?= $o['description']?></td>
        <td><?= $o['object_flag'] ?></td>
        <td><a href="<?= _url('user','admin_edit',array('user_id'=>$u['id']))?>">编辑</a>&nbsp;|&nbsp;
            <a href="<?= _url('user','initial_password',array('user_id'=>$u['id']))?>">密码初始化</a>&nbsp;|&nbsp;
            <?php if($u['inactive_flag'] == 'NO'):?>
                <a href="<?= _url('user','change_status',array('user_id'=>$u['id'],'inactive_flag'=>1))?>">失效</a>
            <?php else : ?>
                <a href="<?= _url('user','change_status',array('user_id'=>$u['id'],'inactive_flag'=>0))?>">生效</a>
            <?php endif; ?>
            &nbsp;|&nbsp;
            <a href="<?= _url('user','choose_roles',array('user_id'=>$u['id']))?>">分配角色</a>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<a href="<?= _url('user','create')?>">新建用户</a>
<?php if(string_to_boolean(_config('allow_register'))) :?>
    |<a href="<?= _url('user','register')?>">用户注册</a>
<?php endif ;?>