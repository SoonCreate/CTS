<?php if(_v('parent')){?>
    <h2>父值集：<?= $parent['description']?></h2>
    <h3>父值集项目：
        <select name="segment" id="segment">
            <?php foreach($lines as $l){?>
                <option value="<?= $l['value']?>"><?= $l['label']?></option>
            <?php }?>
        </select>
        <?php if($parent['segment']['inactive_flag']) : echo '(已失效)' ; endif;?></h3>
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
        <?php if((_v('parent') && $parent['segment']['inactive_flag'] == 0) || !_v('parent')){?>
        <td>
            <a href="<?= _url('valuelist','item_edit',array('id'=>$o['id']))?>">编辑</a>&nbsp;|&nbsp;
            <?php if($o['inactive_flag'] == 'YES') { ?>
            <a href="<?= _url('valuelist','change_item_status',array('id'=>$o['id'],'inactive_flag'=>0))?>">生效</a>
            <?php } else{?>
                <a href="<?= _url('valuelist','change_item_status',array('id'=>$o['id'],'inactive_flag'=>1))?>">失效</a>
            <?php }?>
        </td>
        <?php }?>
    </tr>
    <?php endforeach;?>
</table>
<?php if(_v('parent') ){
    if($parent['segment']['inactive_flag'] == 0){
    ?>
    <a href="<?= _url('valuelist','item_create',array('id'=>v('id'),'parent_segment'=>$parent['segment']['value']))?>">新建项目</a>
<?php }
    }else{?>
<a href="<?= _url('valuelist','item_create',array('id'=>v('id')))?>">新建项目</a>
<?php }?>