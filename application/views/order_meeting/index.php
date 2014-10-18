<table class="table">
    <thead>
    <th>会议主题</th>
    <th>开始时间</th>
    <th>结束时间</th>
    <th>会议地点</th>
    <th>主持人</th>
    <th>状态</th>
    <th>操作</th>
    </thead>
    <?php foreach($objects as $o):?>
        <tr>
            <td><?= $o['title']?></td>
            <td><?= $o['start_date']?></td>
            <td><?= $o['end_date']?></td>
            <td><?= $o['site']?></td>
            <td><?= $o['anchor']?></td>
            <td><?= $o['status']?></td>
            <td>
                <?= render_link(array('order_meeting','show',array('id'=>$o['id'])),label('show'))?>
                <?php if($o['inactive_flag'] == 0) : ?>
                    &nbsp;|&nbsp;
                    <?= render_link(array('order_meeting','edit',array('id'=>$o['id'])),label('edit'))?>
<!--                    &nbsp;|&nbsp;-->
<!--                    --><?php //render_link(array('order_meeting','upload_file',array('id'=>$o['id'])),label('upload_file'))?>
                <?php if( $o['discuss'] == ''|| is_null($o['discuss'])):?>
                        &nbsp;|&nbsp;
                        <?= render_link(array('order_meeting','cancel',array('id'=>$o['id'])),label('cancel'))?>
                <?php endif;
                endif;?>
            </td>

        </tr>
    <?php endforeach;?>
</table>
<?= render_link(array('order_meeting','create',array('order_id'=>_v('order_id'))),label('meeting_create'))?>