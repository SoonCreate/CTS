<table class="table">
    <thead>
        <th>角色名</th>
        <th>描述</th>
        <th>操作</th>
    </thead>
    <?php foreach($roles as $o):?>
    <tr>
        <td><?= $o['role_name']?></td>
        <td><?= $o['description']?></td>

        <td id="roleIndexGridRow">
            <?= render_link(array('role','edit',array('id'=>$o['id'])),label('edit'))?>
            &nbsp;|&nbsp;<?= render_link(array('role','destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
            &nbsp;|&nbsp;<?= render_link(array('role','allocate_users',array('role_id'=>$o['id'])),label('allocate_users'))?>
            &nbsp;|&nbsp;<?= render_link(array('role','choose_functions',array('role_id'=>$o['id'])),label('choose_functions'))?>
            &nbsp;|&nbsp;<?= render_link(array('role','profile',array('role_id'=>$o['id'])),label('auth_object'))?>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('role_create') ?>",url('role/create'));
    toolbarAddButton("<?= label('role_copy') ?>",function(){
        goto(url('role/copy_from'));
    },"<?= label('create_role_as_copy') ?>");
</script>