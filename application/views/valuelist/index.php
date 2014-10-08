<table>
    <thead>
        <th>值集ID</th>
        <th>值集名称</th>
        <th>描述</th>
        <th>来自表/视图</th>
        <th>说明字段</th>
        <th>值字段</th>
        <th>源表/视图</th>
        <th>查询条件</th>
        <th>父值集</th>
        <th>父值集描述</th>
        <th>是否可编辑</th>
        <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
    <tr>
        <td><?= $o['id']?></td>
        <td><?= $o['valuelist_name']?></td>
        <td><?= $o['description']?></td>
        <td><?= $o['object_flag'] ?></td>
        <td><?= $o['label_fieldname'] ?></td>
        <td><?= $o['value_fieldname'] ?></td>
        <td><?= $o['source_view'] ?></td>
        <td><?= $o['condition'] ?></td>
        <td><?= $o['parent_name'] ?></td>
        <td><?= $o['parent_desc'] ?></td>
        <td><?= $o['editable_flag'] ?></td>
        <td>
            <a href="<?= _url('valuelist','edit',array('id'=>$o['id']))?>">编辑</a>&nbsp;|&nbsp;
            <?php if($o['object_flag'] == 'NO') : ?>
            <a href="<?= _url('valuelist','items',array('id'=>$o['id']))?>">管理项目</a>
            <?php endif;?>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<a href="<?= _url('valuelist','create')?>">新建值集</a>