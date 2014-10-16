<table>
    <thead>
        <th>Role_id</th>
        <th>角色名</th>
        <th>描述</th>
        <th>操作</th>
    </thead>
    <?php foreach($roles as $o):?>
    <tr>
        <td><?= $o['id']?></td>
        <td><?= $o['role_name']?></td>
        <td><?= $o['description']?></td>

        <td><?= render_link(array('role','edit',array('id'=>$o['id'])),label('edit'))?>
            &nbsp;|&nbsp;<?= render_link(array('role','destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
            &nbsp;|&nbsp;<?= render_link(array('role','allocate_users',array('role_id'=>$o['id'])),label('allocate_users'))?>
            &nbsp;|&nbsp;<?= render_link(array('role','choose_functions',array('role_id'=>$o['id'])),label('choose_functions'))?>
            &nbsp;|&nbsp;<?= render_link(array('role','profile',array('role_id'=>$o['id'])),label('auth_object'))?>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<?= render_link(array('role','create'),label('role_create'))?>
&nbsp;|&nbsp;
<?= render_link(array('role','copy_from'),label('role_copy'),label('create_role_as_copy'))?>