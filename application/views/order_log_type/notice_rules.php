<table class="table">
    <thead>
    <th>描述</th>
    <th>是否失效</th>
    <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
        <tr>
            <td><?= $o['description']?></td>
            <td><?= $o['inactive_flag']?></td>

            <td>
                <?= render_link(array('order_log_type','notice_rule_edit',array('id'=>$o['id'])),label('edit'))?>
                &nbsp;|&nbsp;
                <?= render_link(array('order_log_type','notice_rule_destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
            </td>

        </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('notice_rule_create') ?>",url('order_log_type/notice_rule_create?log_type_id=<?= v('id') ?>'));
</script>