<table>
    <thead>
        <th>function_id</th>
        <th>功能名</th>
        <th>描述</th>
        <th>控制器</th>
        <th>函数</th>
        <th>操作</th>
    </thead>
    <?php foreach($functions as $fn):?>
    <tr>
        <td><?= $fn['id']?></td>
        <td><?= $fn['function_name']?></td>
        <td><?= $fn['description']?></td>
        <td><?= $fn['controller']?></td>
        <td><?= $fn['action']?></td>

        <td><a href="<?= _url('functions','edit',array('id'=>$fn['id']))?>">编辑</a>&nbsp;|&nbsp;
            <a href="<?= _url('functions','allocate_modules',array('function_id'=>$fn['id']))?>">分配到模块</a>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<a href="<?= _url('functions','create')?>">功能注册</a>