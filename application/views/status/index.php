<table class="table">
    <thead>
        <th><?= label('status_code')?></th>
        <th><?= label('description')?></th>
        <th><?= label('order_name')?></th>
        <th><?= label('operation')?></th>
    </thead>
    <?php foreach($objects as $o):?>
    <tr>
        <td><?= $o['status_code']?></td>
        <td><?= $o['description']?></td>
        <td><?= $o['order_name']?></td>
        <td>
            <?= render_link(array('status','edit',array('id'=>$o['id'])),label('edit'))?>
            &nbsp;|&nbsp;
            <?= render_link(array('status','items',array('id'=>$o['id'])),label('step'))?>
            &nbsp;|&nbsp;
            <?= render_link(array('status','destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('status_create') ?>",url('status/create'));
</script>