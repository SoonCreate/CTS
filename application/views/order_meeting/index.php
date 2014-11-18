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
                    <?php if(_v('can_edit')){
                        echo render_link(array('order_meeting','edit',array('id'=>$o['id'])),label('edit'));
                        echo '&nbsp;|&nbsp;<a href="#" onclick="_orderMeetingUploadDialog('.$o['id'].')">'.label('upload_file').'</a>';
                    }?>
                <?php if( $o['discuss'] == ''|| is_null($o['discuss'])):?>
                        &nbsp;|&nbsp;
                        <?php if(_v('can_cancel')){
                                echo  render_link(array('order_meeting','cancel',array('id'=>$o['id'])),label('cancel'));}?>
                <?php endif;
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
<script type="text/javascript">
    function _orderMeetingUploadDialog(id){
        require(["dojox/layout/ContentPane","dojo/io/iframe"],function(ContentPane,iframe){
            var cp = new ContentPane({
                href : url("order_meeting/upload_file?id="+id),
                id : "uploadFileContentPane"
            });
            cp.startup();
            dojoConfirm(cp,"文件上传",function(){
                iframe.send({
                    form: "upload_file",
                    method: "POST",
                    timeOut: 2000,
                    handleAs: "json",
                    url : url("order_meeting/upload_file")
                }).then(function(response) {
                    //成功
                    handleResponse(response,null,function(){
                        refresh();
                    })
                },function (error) {
                    //失败
                    console.info(error);
                });
            });
        });
    }
</script>