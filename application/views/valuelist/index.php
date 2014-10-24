<table class="table">
    <thead>
        <th>值集名称</th>
        <th>描述</th>
        <th>父值集</th>
        <th>父值集描述</th>
        <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
    <tr>
        <td><?= $o['valuelist_name']?></td>
        <td><?= $o['description']?></td>
        <td><?= $o['parent_name'] ?></td>
        <td><?= $o['parent_desc'] ?></td>
        <td>
            <?= render_link(array('valuelist','edit',array('id'=>$o['id'])),label('edit'))?>
            &nbsp;|&nbsp;
            <?php
            $s = label('item_manage');
            if($o['object_flag']) {
                $s = label('item_show');
            }?>
            <?= render_link(array('valuelist','items',array('id'=>$o['id'])),$s)?>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<div class="row">
    <?= render_link_button(array('valuelist','create'),label('valuelist_create'))?>
</div>