<table class="table">
    <thead>
        <th><?= label('module_name')?></th>
        <th><?= label('description')?></th>
        <th><?= label('sort')?></th>
        <th><?= label('operation')?></th>
    </thead>
    <?php foreach($modules as $o):?>
    <tr>
        <td><?= $o['module_name']?></td>
        <td><?= $o['description']?></td>
        <td><?= $o['sort']?></td>

        <td>
            <?= render_link(array('modules','edit',array('id'=>$o['id'])),label('edit'))?>
            &nbsp;|&nbsp;
            <?= render_link(array('modules','destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
            &nbsp;|&nbsp;
            <?= render_link(array('modules','choose_functions',array('module_id'=>$o['id'])),label('choose_functions'))?>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('module_create') ?>",url('modules/create'));
</script>