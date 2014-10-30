<table class="table">
    <thead>
        <th>与或关系</th>
        <th>表</th>
        <th>字段</th>
        <th>运算公式</th>
        <th>目标值</th>
        <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
    <tr>
        <td><?= $o['and_or']?></td>
        <td><?= $o['table_name']?></td>
        <td><?= $o['field_name']?></td>
        <td><?= $o['operation']?></td>
        <td><?= $o['target_value']?></td>
        <td>
            <?= render_link(array('status','condition_edit',array('id'=>$o['id'])),label('edit'))?>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('condition_create') ?>",url('status/condition_create?line_id=<?= _v('id') ?>'));
</script>