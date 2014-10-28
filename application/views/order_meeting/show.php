<div class="row paneltitle">
    <h3>会议纪要</h3>
</div>
<div class="container-fluid userd">
    <dl class="row dl-horizontal"><dt>状态 :</dt><dd><?= _v('status')?></dd></dl>
    <dl class="row dl-horizontal"><dt>会议主题 : </dt><dd><?= _v('title')?></dd></dl>
    <dl class="row dl-horizontal"><dt>开始时间 : </dt><dd><?= _v('start_date')?></dd></dl>
    <dl class="row dl-horizontal"><dt>结束时间 : </dt><dd><?= _v('end_date')?></dd></dl>
    <dl class="row dl-horizontal"><dt>会议地点 : </dt><dd><?= _v('site')?></dd></dl>
    <dl class="row dl-horizontal"><dt>主持人 : </dt><dd><?= _v('anchor')?></dd></dl>
    <dl class="row dl-horizontal"><dt>记录人 : </dt><dd><?= _v('recorder')?></dd></dl>
    <dl class="row dl-horizontal"><dt>参与者 : </dt><dd><?= _v('actor')?></dd></dl>
    <dl class="row dl-horizontal"><dt>会议决议 : </dt><dd><?= _v('discuss')?></dd></dl>
    <dl class="row dl-horizontal"><dt>处理投诉单 :</dt><dd><?php
            $links = array();
            foreach($orders as $o){
                $link =   render_link(array('order','show',array('id'=>$o['order_id'])),$o['order_id'],$o['order_title']) ;
                array_unshift($links,$link);
            }
            echo join(',',$links);
            ?></dd></dl>
    <dl class="row dl-horizontal"><dt>会议相关文件：</dt><dd><?php foreach($files as $f){
//更改文件名下载使用以下，需加入download的helper
//   echo  force_download($f['client_name'], file_get_contents(FCPATH._config('upload_path').'/'.$f['file_name']));
                echo render_file_link($f);
                echo '&nbsp;&nbsp;&nbsp;'.$f['description'].'<br/>';
            }?></dd></dl>

</div>
