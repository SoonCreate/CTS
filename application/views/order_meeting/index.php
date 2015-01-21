<table class="table">
    <thead>
    <th><?= label('meeting_title')?></th>
    <th><?= label('start_date')?></th>
    <th><?= label('end_date')?></th>
    <th><?= label('site')?></th>
    <th><?= label('anchor')?></th>
    <th><?= label('status')?></th>
    <th><?= label('file_count')?></th>
    <th><?= label('operation')?></th>
    </thead>
    <?php foreach($objects as $o):?>
        <tr>
            <td><?= $o['title']?></td>
            <td><?= $o['start_date']?></td>
            <td><?= $o['end_date']?></td>
            <td><?= $o['site']?></td>
            <td><?= $o['anchor']?></td>
            <td><?= $o['status']?></td>
            <td><?= $o['file_count']?></td>
            <td>
                <?= render_link(array('order_meeting','show',array('id'=>$o['id'])),label('show'))?>
                <?php if($o['inactive_flag'] == 0) : ?>
                    &nbsp;|&nbsp;
                    <?php if(_v('can_edit')) :
                        echo render_link(array('order_meeting','edit',array('id'=>$o['id'])),label('edit'));
                        ?>
                        &nbsp;|&nbsp;<a href="#" onclick="uploadFileDialog('order_meeting/upload_file',{id : <?= $o['id'] ?>})">
                            <?= label('upload_file') ?></a>
                    <?php endif ?>
                <?php if( $o['discuss'] == ''|| is_null($o['discuss'])):?>
                        &nbsp;|&nbsp;
                        <?php if(_v('can_cancel')){
                                echo  render_link(array('order_meeting','cancel',array('id'=>$o['id'])),label('cancel'));}?>
                <?php endif;?>
                    &nbsp;|&nbsp;
                <?php
                    echo  render_link(array('order_meeting','notice_actor',array('id'=>$o['id'])),label('notice_actor'),null,null,true);
                endif;?>
            </td>

        </tr>
    <?php endforeach;?>
</table>
<?php if(_v('can_create')){ ?>

    <script type="text/javascript">
        toolBarAddLinkButton("<?= label('meeting_create') ?>",url('order_meeting/create?order_id=<?= _v('order_id') ?>'));
    </script>

<?php } ?>