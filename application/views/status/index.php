<table class="table">
    <thead>
        <th>状态流名称</th>
        <th>描述</th>
        <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
    <tr>
        <td><?= $o['status_code']?></td>
        <td><?= $o['description']?></td>
        <td>
            <?= render_link(array('status','edit',array('id'=>$o['id'])),label('edit'))?>
            &nbsp;|&nbsp;
            <?= render_link(array('status','items',array('id'=>$o['id'])),label('items'))?>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('status_create') ?>",url('status/create'));
</script>