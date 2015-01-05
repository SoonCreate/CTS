<table class="table">
    <thead>
    <th><?= label('segment_name')?></th>
    <th><?= label('value')?></th>
    <th><?= label('data_type')?></th>
    <th><?= label('now_flag')?></th>
    <th><?= label('operation')?></th>
    </thead>
    <?php foreach($objects as $o):?>
        <tr>
            <td><?= $o['segment_name']?></td>
            <td><?= $o['segment_value']?></td>
            <td><?= $o['data_type']?></td>
            <td><?= $o['now_flag']?></td>
            <td>
                <?= render_link(array('functions','variant_item_edit',array('id'=>$o['id'])),label('edit'))?>
                &nbsp;|&nbsp;
                <?= render_link(array('functions','variant_item_destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
            </td>

        </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('variant_item_create') ?>",url('functions/variant_item_create?variant_id=<?= v('variant_id') ?>'));
</script>