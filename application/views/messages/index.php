<table class="table">
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
            <?= render_link(array('messages','class_edit',array('id'=>$o['id'])),label('edit'))?>
            &nbsp;|&nbsp;<?= render_link(array('messages','items',array('class_id'=>$o['id'])),label('item_manage'))?>
            &nbsp;|&nbsp;<?= render_link(array('messages','class_destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<?= render_link(array('messages','class_create'),label('class_create'))?>