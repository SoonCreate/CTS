<table class="table">
    <thead>
        <th>值集名称</th>
        <th>描述</th>
        <th>父值集</th>
        <th>父值集描述</th>
        <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
    <tr>
        <td><?= $o['valuelist_name']?></td>
        <td><?= $o['description']?></td>
        <td><?= $o['parent_name'] ?></td>
        <td><?= $o['parent_desc'] ?></td>
        <td>
            <?php if($o['editable_flag']){?>
            <?= render_link(array('valuelist','edit',array('id'=>$o['id'])),label('edit'))?>&nbsp;|&nbsp;
            <?php }?>
            <?= render_link(array('valuelist','items',array('id'=>$o['id'])),label('items'))?>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('valuelist_create') ?>",url('valuelist/create'));
</script>