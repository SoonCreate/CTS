<?php if(_v('parent')){?>
    父值集：<?= $parent['description']?><br/>
    父值集项目：<?= $parent['segment_desc']?>
<?php }?>
<table>
    <thead>
        <th>段</th>
        <th>段值</th>
        <th>段描述</th>
        <th>是否失效</th>
        <th>排序码</th>
        <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
    <tr>
        <td><?= $o['segment']?></td>
        <td><?= $o['segment_value']?></td>
        <td><?= $o['segment_desc']?></td>
        <td><?= $o['inactive_flag'] ?></td>
        <td><?= $o['sort'] ?></td>
        <td>
            <a href="<?= _url('valuelist','item_edit',array('id'=>$o['id']))?>">编辑</a>&nbsp;|&nbsp;
            <?php if($o['inactive_flag'] == 'YES') { ?>
            <a href="<?= _url('valuelist','change_item_status',array('id'=>$o['id'],'inactive_flag'=>0))?>">生效</a>
            <?php } else{?>
                <a href="<?= _url('valuelist','change_item_status',array('id'=>$o['id'],'inactive_flag'=>1))?>">失效</a>
            <?php }?>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<a href="<?= _url('valuelist','item_create')?>">新建项目</a>