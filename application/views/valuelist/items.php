<?php if(_v('parent')){    ?>
    <dl class="row dl-horizontal"> <dt>父值集项目</dt><dd>
        <select name="segment" id="segment" data-dojo-type="sckj/form/Select" value="<?= _v('parent_segment')?>"
                onchange="_valuelistItemData(this)">
            <?php foreach($lines as $l){?>
                <option value="<?= $l['value']?>"><?= $l['label']?></option>
            <?php }?>
        </select>
            <?php if(_v('parent_inactive_flag')) : echo '(已失效)' ; endif;?>
            </dd>
        </dl>
<?php }?>
<table  class="table">
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
        <?php if(!_v('parent_inactive_flag') && _v('editable_flag')) {?>
                <?= render_link(array('valuelist','item_edit',array('id'=>$o['id'])),label('edit'))?>
                &nbsp;|&nbsp;
                <?php if($o['inactive_flag']) { ?>
                    <?= render_link(array('valuelist','change_item_status',array('id'=>$o['id'],'inactive_flag'=>0)),label('active'),null,null,true)?>
                <?php } else{?>
                    <?= render_link(array('valuelist','change_item_status',array('id'=>$o['id'],'inactive_flag'=>1)),label('inactive'),null,null,true)?>
                <?php }?>
        <?php }?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php if(!_v('parent_inactive_flag') && _v('editable_flag')) {
            if (_v('parent')) { ?>

                <script type="text/javascript">
                    toolBarAddLinkButton("<?= label('item_create') ?>",url('valuelist/item_create?id=<?= v('id')?>&parent_segment=<?= _v('parent_segment') ?>'));
                </script>

                <?= render_link(array('valuelist', 'item_create', array('id' => v('id'), 'parent_segment' => _v('parent_segment'))),
                    label('item_create')) ?>
            <?php } else { ?>
                <?= render_link(array('valuelist', 'item_create', array('id' => v('id'))),
                    label('item_create')) ?>
            <?php
            }
}?>

<script type="text/javascript">
    function _valuelistItemData(object){
        goto(url('valuelist/items?id=<?= v('id')?>&parent_segment='+object.getValue()),null,null,true);
    }
</script>