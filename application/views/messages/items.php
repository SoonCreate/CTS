<h2><?= $description ?></h2>
<h3>Class_code：<?= $class_code ?></h3>
<table class="table">
    <thead>
        <th>消息码</th>
        <th>内容</th>
        <th>语言环境</th>
        <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
    <tr>
        <td><?= $o['message_code']?></td>
        <td><?= $o['content']?></td>
        <td><?= $o['language']?></td>
        <td>
            <?= render_link(array('messages','edit',array('id'=>$o['id'])),label('edit'))?>
            &nbsp;|&nbsp;
            <?= render_link(array('messages','destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<?= render_link(array('messages','create',array('class_id'=>v('class_id'))),label('message_create'))?>
