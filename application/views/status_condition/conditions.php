<table class="table">
    <thead>
        <th><?= label('and_or') ?></th>
        <th><?= label('table_name') ?></th>
        <th><?= label('field_name') ?></th>
        <th><?= label('operational_formula') ?></th>
        <th><?= label('target_value') ?></th>
        <th><?= label('operation') ?></th>
    </thead>
    <?php foreach($objects as $o):?>
    <tr>
        <td><?= $o['and_or']?></td>
        <td><?= $o['table_name']?></td>
        <td><?= $o['field_name']?></td>
        <td><?= $o['operation']?></td>
        <td><?= $o['target_value']?></td>
        <td>
            <?= render_link(array('status_condition','edit',array('id'=>$o['id'])),label('edit'))?>
            &nbsp;|&nbsp;
            <?= render_link(array('status_condition','destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('condition_create') ?>",url('status_condition/create?group_id=<?= _v('group_id') ?>'));
</script>