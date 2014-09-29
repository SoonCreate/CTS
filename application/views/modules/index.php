<table>
    <thead>
        <th>module_id</th>
        <th>模块名</th>
        <th>描述</th>
        <th>排序码</th>
        <th>操作</th>
    </thead>
    <?php foreach($modules as $o):?>
    <tr>
        <td><?= $o['id']?></td>
        <td><?= $o['module_name']?></td>
        <td><?= $o['description']?></td>
        <td><?= $o['sort']?></td>

        <td><a href="<?= _url('modules','edit',array('id'=>$o['id']))?>">编辑</a>&nbsp;|&nbsp;
            <a href="<?= _url('modules','destroy',array('id'=>$o['id']))?>">删除</a>&nbsp;|&nbsp;
            <a href="<?= _url('modules','choose_functions',array('module_id'=>$o['id']))?>">选择功能</a>&nbsp;|&nbsp;
            <a href="<?= _url('modules','has_roles',array('module_id'=>$o['id']))?>">被用于哪些角色</a>&nbsp;|&nbsp;
            <a href="<?= _url('modules','has_users',array('module_id'=>$o['id']))?>">被用于哪些用户</a>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<a href="<?= _url('modules','create')?>">模块创建</a>