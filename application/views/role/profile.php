<?= render_form_header('profile');?>
<table class="table">
    <thead>
    <th>权限对象</th>
    <th>权限对象描述</th>
    <th>操作</th>
    </thead>
    <?php foreach($objects as $o) :?>
        <tr>
            <td><?= $o['object_name'] ?></td>
            <td><?= $o['object_desc'] ?></td>
            <td>
                <?= render_link(array('role','profile_object_items',array('id'=>$o['id'])),label('item_manage'))?>
                &nbsp;|&nbsp;<?= render_link(array('role','profile_destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('create_object') ?>",url('role/profile_add_object?role_id=<?= v('role_id')?>'));
</script>

