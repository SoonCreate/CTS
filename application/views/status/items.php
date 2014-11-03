<table class="table">
    <thead>
        <th>步骤</th>
        <th>状态</th>
        <th>状态描述</th>
        <th>下一步允许范围</th>
        <th>默认下一步骤</th>
        <th>默认撤回步骤</th>
        <th>初始步骤标识</th>
        <th>最终步骤标识</th>
        <th>自动结束标识</th>
        <th>是否失效</th>
        <th>操作</th>
    </thead>
    <?php foreach($items as $o):?>
    <tr>
        <td><?= $o['step']?></td>
        <td><?= $o['step_value']?></td>
        <td><?= $o['step_desc']?></td>
        <td><?= $o['next_steps']?></td>
        <td><?= $o['default_next_step']?></td>
        <td><?= $o['callback_step']?></td>
        <td><?= $o['initial_flag']?></td>
        <td><?= $o['last_step_flag']?></td>
        <td><?= $o['auto_ending_flag']?></td>
        <td><?= $o['inactive_flag']?></td>
        <td>
            <?= render_link(array('status','item_edit',array('id'=>$o['id'])),label('edit'))?>
            &nbsp;|&nbsp;
            <?= render_link(array('status','item_destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
            &nbsp;|&nbsp;
            <?= render_link(array('status_condition','groups',array('id'=>$o['id'])),label('conditions'))?>
            &nbsp;|&nbsp;
            <?= render_link(array('status','functions',array('id'=>$o['id'])),label('functions'))?>
        </td>

    </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('step_create') ?>",url('status/item_create?status_id=<?= _v('id') ?>'));
</script>