<div class="container-fluid userd">
    <dl class="row dl-horizontal"><dt><?= label('status')?> :</dt><dd><?= _v('status')?></dd></dl>
    <?php if(_v('cancel_reason')){?>
        <dl class="row dl-horizontal"><dt><?= label('cancel_reason')?> :</dt><dd><?= get_label('vl_meeting_cancel',_v('cancel_reason'))?></dd></dl>
        <dl class="row dl-horizontal"><dt><?= label('cancel_remark')?> :</dt><dd><?= _v('cancel_remark')?></dd></dl>
    <?php }?>
    <dl class="row dl-horizontal"><dt><?= label('meeting_title') ?> : </dt><dd><?= _v('title')?></dd></dl>
    <dl class="row dl-horizontal"><dt><?= label('start_date') ?> : </dt><dd><?= _v('start_date')?></dd></dl>
    <dl class="row dl-horizontal"><dt><?= label('end_date') ?> : </dt><dd><?= _v('end_date')?></dd></dl>
    <dl class="row dl-horizontal"><dt><?= label('site') ?> : </dt><dd><?= _v('site')?></dd></dl>
    <dl class="row dl-horizontal"><dt><?= label('anchor') ?> : </dt><dd><?= _v('anchor')?></dd></dl>
    <dl class="row dl-horizontal"><dt><?= label('recorder') ?> : </dt><dd><?= _v('recorder')?></dd></dl>
    <dl class="row dl-horizontal"><dt><?= label('actor') ?> : </dt><dd><?= _v('actor')?></dd></dl>
    <dl class="row dl-horizontal"><dt><?= label('discuss') ?> : </dt><dd><?= _v('discuss')?></dd></dl>
    <dl class="row dl-horizontal"><dt><?= label('order_id')?> :</dt><dd><?php
            $links = array();
            foreach($orders as $o){
                $link =   render_link(array('order','show',array('id'=>$o['order_id'])),$o['order_id'],$o['order_title']) ;
                array_unshift($links,$link);
            }
            echo join(',',$links);
            ?></dd></dl>
    <dl class="row dl-horizontal"><dt><?= label('file')?> :</dt><dd><?php foreach($files as $f){
//更改文件名下载使用以下，需加入download的helper
//   echo  force_download($f['client_name'], file_get_contents(FCPATH._config('upload_path').'/'.$f['file_name']));
                echo render_file_link($f);
                echo '&nbsp;&nbsp;&nbsp;'.$f['description'].'<br/>';
            }?></dd></dl>

</div>
