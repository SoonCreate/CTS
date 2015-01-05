<table class="table">
    <thead>
    <th><?= label('variant_name')?></th>
    <th><?= label('description')?></th>
    <th><?= label('share_flag')?></th>
    <th><?= label('background_flag')?></th>
    <th><?= label('owner')?></th>
    <th><?= label('operation')?></th>
    </thead>
    <?php foreach($objects as $o):?>
        <tr>
            <td><?= $o['variant_name']?></td>
            <td><?= $o['description']?></td>
            <td><?= $o['share_flag']?></td>
            <td><?= $o['background_flag']?></td>
            <td><?= $o['created_by']?></td>
            <td>
                <?= render_link(array('functions','variant_edit',array('id'=>$o['id'])),label('edit'))?>
                &nbsp;|&nbsp;
                <?= render_link(array('functions','variant_destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
                &nbsp;|&nbsp;
                <?= render_link(array('functions','variant_items',array('variant_id'=>$o['id'])),label('items'))?>
            </td>

        </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('variant_create') ?>",url('functions/variant_create?function_id=<?= v('id') ?>'));
</script>