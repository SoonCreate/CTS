<table class="table">
    <thead>
    <th><?= label('log_type') ?></th>
    <th><?= label('description') ?></th>
    <th><?= label('title') ?></th>
<!--    <th>--><?//= label('content') ?><!--</th>-->
    <th><?= label('need_reason_flag') ?></th>
    <th><?= label('field_name') ?></th>
    <th><?= label('dll_type') ?></th>
    <th><?= label('operation') ?></th>
    </thead>
    <?php foreach($objects as $o):?>
        <tr>
            <td><?= $o['log_type']?></td>
            <td><?= $o['description']?></td>
            <td><?= word_truncate($o['title'])?></td>
<!--            <td>--><?//= word_truncate($o['content'])?><!--</td>-->
            <td><?= $o['need_reason_flag']?></td>
            <td><?= $o['field_name']?></td>
            <td><?= $o['dll_type']?></td>

            <td>
                <?= render_link(array('order_log_type','edit',array('id'=>$o['id'])),label('edit'))?>
                &nbsp;|&nbsp;
                <?= render_link(array('order_log_type','destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
                &nbsp;|&nbsp;
                <?= render_link(array('order_log_type','notice_rules',array('id'=>$o['id'])),label('notice_rules'))?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('log_type_create') ?>",url('order_log_type/create'));
</script>