<table class="table">
    <thead>
        <th><?= label('item_name')?></th>
        <th><?= label('description')?></th>
        <th><?= label('default_value')?></th>
        <th><?= label('operation')?></th>
    </thead>
    <?php foreach($items as $o):?>
    <tr>
        <td><?= $o['auth_item_name']?></td>
        <td><?= $o['auth_item_desc']?></td>
        <td><?= $o['default_value']?></td>

        <td>
            <?= render_link(array('functions','object_item_edit',array('id'=>$o['id'])),label('edit'))?>
        </td>

    </tr>
    <?php endforeach;?>
</table>