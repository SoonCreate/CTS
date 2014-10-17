<table>
    <thead>
        <th>项目名</th>
        <th>项目描述</th>
        <th>默认值</th>
        <th>操作</th>
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