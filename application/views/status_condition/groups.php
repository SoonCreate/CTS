<table class="table">
    <thead>
        <th>条件组</th>
        <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
    <tr>
        <td><?= $o['group_name']?></td>
        <td>
            <?= render_link(array('status_condition','group_edit',array('id'=>$o['id'])),label('edit'))?>
            &nbsp;|&nbsp;
            <?= render_link(array('status_condition','group_destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
            &nbsp;|&nbsp;
            <?= render_link(array('status_condition','conditions',array('group_id'=>$o['id'])),label('conditions'))?>
            &nbsp;|&nbsp;
            <?= render_link(array('status_condition','objects',array('group_id'=>$o['id'])),label('objects'))?>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('condition_group_create') ?>",url('status_condition/group_create?status_line_id=<?= _v('id') ?>'));
</script>