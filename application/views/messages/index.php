<table>
    <thead>
        <th>消息类ID</th>
        <th>消息类</th>
        <th>类描述</th>
        <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
    <tr>
        <td><?= $o['id']?></td>
        <td><?= $o['class_code']?></td>
        <td><?= $o['description']?></td>
        <td>
            <a href="<?= _url('messages','class_edit',array('id'=>$o['id']))?>">编辑</a>
            &nbsp;|&nbsp;
            <a href="<?= _url('messages','items',array('class_id'=>$o['id']))?>">管理条目</a>
            &nbsp;|&nbsp;
            <a href="<?= _url('messages','class_destroy',array('id'=>$o['id']))?>">删除</a>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<a href="<?= _url('messages','class_create')?>">新建消息类</a>