<table>
    <thead>
    <th>消息编号</th>
    <th>标题</th>
    <th>接收时间</th>
    <th>是否已读</th>
    </thead>
    <?php foreach($notices as $o):?>
        <tr>
            <td><?= $o['id']?></td>
            <td><a href="<?= _url('user','notice_show',array('id'=>$o['id']))?>"><?= word_truncate($o['title']) ?></td>
            <td><?= $o['creation_date']?></td>
            <td><?= $o['read_flag']?></td>
        </tr>
    <?php endforeach;?>
</table>