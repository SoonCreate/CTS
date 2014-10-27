<table class="table">
    <thead>
    <th>id</th>
    <th>权限对象名</th>
    <th>描述</th>
    <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
        <tr>
            <td><?= $o['id']?></td>
            <td><?= $o['object_name']?></td>
            <td><?= $o['description']?></td>
            <td>
                <?= render_link(array('functions','object_items',array('id'=>$o['id'])),label('items'))?>
                &nbsp;|&nbsp;
                <?= render_link(array('functions','object_destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
            </td>

        </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('object_create') ?>",url('functions/object_create?function_id=<?= v('id') ?>'));
</script>