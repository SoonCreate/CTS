<?php if($inactive_flag === 'YES'): echo '状态：已取消';endif;?><br/>
会议主题 : <?= _v('title')?><br/>
开始时间 : <?= _v('start_date')?><br/>
结束时间 : <?= _v('end_date')?><br/>
会议地点 : <?= _v('site')?><br/>
主持人 : <?= _v('anchor')?><br/>
记录人 : <?= _v('recorder')?><br/>
参与者 : <?= _v('actor')?><br/>
会议决议 : <?= _v('discuss')?><br/>
处理投诉单 :
<?php foreach($orders as $o){
    echo '<a href="'._url('order','show',array('id'=>$o['order_id'])).'" title="'.$o['order_title'].'">'.$o['order_id'].'</a>';
}?>
<br/>
会议相关文件：
<?php foreach($files as $f){
//更改文件名下载使用以下，需加入download的helper
//   echo  force_download($f['client_name'], file_get_contents(FCPATH._config('upload_path').'/'.$f['file_name']));
    echo render_file_link($f);
}?>