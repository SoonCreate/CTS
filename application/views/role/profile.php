<?= render_form_header('profile');?>
<?= render_link(array('role','profile_add_object',array('role_id'=>v('role_id'))),label('add_object'))?>

<table>
    <thead>
    <th>profile_id</th>
    <th>权限对象</th>
    <th>权限对象描述</th>
    <th>操作</th>
    </thead>
    <?php foreach($objects as $o) :?>
        <tr>
            <td><?= $o['id'] ?></td>
            <td><?= $o['object_name'] ?></td>
            <td><?= $o['object_desc'] ?></td>
            <td>
                <?= render_link(array('role','profile_object_items',array('id'=>$o['id'])),label('item_manage'))?>
                &nbsp;|&nbsp;<?= render_link(array('role','profile_destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
            </td>
        </tr>
    <?php endforeach;?>
</table>

