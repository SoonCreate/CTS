<table class="table">
    <thead>
        <th>消息类</th>
        <th>类描述</th>
        <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
    <tr>
        <td><?= $o['class_code']?></td>
        <td><?= $o['description']?></td>
        <td>
            <?= render_link(array('messages','class_edit',array('id'=>$o['id'])),label('edit'))?>
            &nbsp;|&nbsp;<?= render_link(array('messages','items',array('class_id'=>$o['id'])),label('message_manage'))?>
            &nbsp;|&nbsp;<?= render_link(array('messages','class_destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('class_create') ?>",url('messages/class_create'));
</script>