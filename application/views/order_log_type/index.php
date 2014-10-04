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
            <td><?= word_substr($o['title'],200)?></td>
            <td><?=word_substr($o['content'],200)?></td>
            <td><?= $o['need_reason_flag']?></td>
            <td><?= $o['notice_flag']?></td>
            <td><?= $o['field_name']?></td>
            <td><?= $o['dll_type']?></td>

            <td><a href="<?= _url('order_log_type','edit',array('id'=>$o['id']))?>">编辑</a>&nbsp;|&nbsp;
                <a href="<?= _url('order_log_type','destroy',array('id'=>$o['id']))?>">删除</a>
            </td>

        </tr>
    <?php endforeach;?>
</table>
<a href="<?= _url('order_log_type','create')?>">新建日志类型</a>