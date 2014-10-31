<table class="table">
    <thead>
        <th>功能名</th>
        <th>描述</th>
        <th>按钮标签</th>
        <th>排序码</th>
        <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
    <tr>
        <td><?= $o['function_name']?></td>
        <td><?= $o['description']?></td>
        <td><?= $o['label']?></td>
        <td><?= $o['sort']?></td>
        <td>
            <?= render_link(array('status','function_edit',array('id'=>$o['id'])),label('edit'))?>
            &nbsp;|&nbsp;
            <?= render_link(array('status','function_destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('function_create') ?>",url('status/function_create?status_line_id=<?= _v('id') ?>'));
</script>