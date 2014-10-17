<table>
    <thead>
    <th>类型</th>
    <th>描述</th>
    <th>标题格式</th>
    <th>内容格式</th>
    <th>是否需要填写原因</th>
    <th>是否需要同时创建通知</th>
    <th>对应字段</th>
    <th>数据库操作</th>
    <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
        <tr>
            <td><?= $o['log_type']?></td>
            <td><?= $o['description']?></td>
            <td><?= word_truncate($o['title'])?></td>
            <td><?= word_truncate($o['content'])?></td>
            <td><?= $o['need_reason_flag']?></td>
            <td><?= $o['notice_flag']?></td>
            <td><?= $o['field_name']?></td>
            <td><?= $o['dll_type']?></td>

            <td>
                <?= render_link(array('order_log_type','edit',array('id'=>$o['id'])),label('edit'))?>
                &nbsp;|&nbsp;
                <?= render_link(array('order_log_type','destroy',array('id'=>$o['id'])),label('destroy'),null,null,true)?>
            </td>

        </tr>
    <?php endforeach;?>
</table>
<?= render_link(array('order_log_type','create'),label('order_log_type_create'))?>