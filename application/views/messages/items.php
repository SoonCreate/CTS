<h2><?= $description ?></h2>
<h3>Class_code：<?= $class_code ?></h3>
<table>
    <thead>
        <th>消息码</th>
        <th>内容</th>
        <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
    <tr>
        <td><?= $o['message_code']?></td>
        <td><?= $o['content']?></td>
        <td>
            <a href="<?= _url('messages','edit',array('id'=>$o['id']))?>">编辑</a>
            &nbsp;|&nbsp;
            <a href="<?= _url('messages','destroy',array('id'=>$o['id']))?>">删除</a>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<a href="<?= _url('messages','create',array('class_id'=>v('class_id')))?>">新建条目</a>
