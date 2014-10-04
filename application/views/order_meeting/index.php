<table>
    <thead>
    <th>会议主题</th>
    <th>开始时间</th>
    <th>结束时间</th>
    <th>会议地点</th>
    <th>主持人</th>
    <th>记录人</th>
    <th>参与者</th>
    <th>会议决议</th>
    <th>是否已取消</th>
    <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
        <tr>
            <td><?= $o['title']?></td>
            <td><?= $o['start_date']?></td>
            <td><?= $o['end_date']?></td>
            <td><?= $o['site']?></td>
            <td><?= $o['anchor']?></td>
            <td><?= $o['recorder']?></td>
            <td><?= $o['actor']?></td>
            <td><?= word_truncate($o['discuss'])?></td>
            <td><?= $o['inactive_flag']?></td>
            <td>
                <a href="<?= _url('order_meeting','show',array('id'=>$o['id']))?>">查看</a>
                <?php if($o['inactive_flag'] === 'NO') : ?>
                    &nbsp;|&nbsp;<a href="<?= _url('order_meeting','edit',array('id'=>$o['id']))?>">编辑</a>

                    &nbsp;|&nbsp;<a href="<?= _url('order_meeting','upload_file',array('id'=>$o['id']))?>">上传会议相关文件</a>
                <?php if( $o['discuss'] === ''):?>
                        &nbsp;|&nbsp;<a href="<?= _url('order_meeting','cancel',array('id'=>$o['id']))?>">取消会议</a>
                <?php endif;
                endif;?>
            </td>

        </tr>
    <?php endforeach;?>
</table>
<a href="<?= _url('order_meeting','create',array('order_id'=>_v('order_id')))?>">召开新会议</a>