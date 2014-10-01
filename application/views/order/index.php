<table>
    <thead>
        <th>投诉单号</th>
        <th>订单类型</th>
        <th>分类</th>
        <th>创建人</th>
        <th>状态</th>
        <th>标题</th>
        <th>内容</th>
        <th>负责人</th>
        <th>提交时间</th>
        <th>计划完成时间</th>
        <th>已延期</th>
        <th>报警次数</th>
        <th>计划完成日期修改次数</th>
        <th>召开过几次会议</th>
        <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
    <tr>
        <td><?= $o['id']?></td>
        <td><?= $o['order_type']?></td>
        <td><?= $o['category']?></td>
        <td><?= $o['created_by']?></td>
        <td><?= $o['status']?></td>
        <td><?= $o['title']?></td>
        <td><?= word_substr($o['content'],200)?></td>
        <td><?= $o['managed_by']?></td>
        <td><?= related_time($o['creation_date'])?></td>
        <td><?= $o['plan_complete_date']?></td>
        <td><?= $o['delay_flag']?></td>
        <td><?= $o['warning_count']?></td>
        <td><?= $o['plan_date_count']?></td>
        <td></td>
        <td><a href="<?= _url('order','show',array('id'=>$o['id']))?>">查看</a></td>
    </tr>
    <?php endforeach;?>
</table>