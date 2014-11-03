<table class="table">
    <thead>
        <th>权限对象名称</th>
        <th>描述</th>
        <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
    <tr>
        <td><?= $o['object_name']?></td>
        <td><?= $o['description']?></td>
        <td>
            <?= render_link(array('status_condition','object_items',array('id'=>$o['id'])),label('items'))?>
            &nbsp;|&nbsp;
            <?= render_link(array('status_condition','object_destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('add_object') ?>",url('status_condition/add_object?group_id=<?= _v('group_id') ?>'));
</script>