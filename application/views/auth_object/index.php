<table class="table">
    <thead>
        <th><?= label('object_name')?></th>
        <th><?= label('description')?></th>
        <th><?= label('operation')?></th>
    </thead>
    <?php foreach($objects as $o):?>
    <tr>
        <td><?= $o['object_name']?></td>
        <td><?= $o['description']?></td>

        <td>
            <?= render_link(array('auth_object','edit',array('id'=>$o['id'])),label('edit'))?>
            &nbsp;|&nbsp;
            <?= render_link(array('auth_object','destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
            &nbsp;|&nbsp;
            <?= render_link(array('auth_object','items',array('id'=>$o['id'])),label('items'))?>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('auth_object_create') ?>",url('auth_object/create'));
</script>