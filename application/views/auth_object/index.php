<table class="table">
    <thead>
        <th>object_id</th>
        <th>权限对象名</th>
        <th>描述</th>
        <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
    <tr>
        <td><?= $o['id']?></td>
        <td><?= $o['object_name']?></td>
        <td><?= $o['description']?></td>

        <td>
            <?= render_link(array('auth_object','edit',array('id'=>$o['id'])),label('edit'))?>
            &nbsp;|&nbsp;
            <?= render_link(array('auth_object','destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
            &nbsp;|&nbsp;
            <?= render_link(array('auth_object','items',array('id'=>$o['id'])),label('items'))?>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<?= render_link(array('auth_object','create'),label('auth_object_create'))?>