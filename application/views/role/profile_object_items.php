<table class="table">
    <thead>
    <th>项目名称</th>
    <th>项目描述</th>
    <th>项目值</th>
    <th>操作</th>
    </thead>
    <?php foreach($objects as $o) :?>
        <tr>
            <td><?= $o['auth_item_name'] ?></td>
            <td><?= $o['auth_item_desc'] ?></td>
            <td><?= $o['auth_value'] ?></td>
            <td><?= render_link(array('role','profile_object_item_edit',array('id'=>$o['id'])),label('edit'))?></td>
        </tr>
    <?php endforeach;?>
</table>
