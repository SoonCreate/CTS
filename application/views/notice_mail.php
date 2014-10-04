<strong>您好，<?= full_name($received_by)?></strong><br/>
<p><?= $content ?></p>
<p>
    详情请点击：<a href="<?= _url('user','notice_show',array('id'=>$id))?>"><?= _url('user','notice_show',array('id'=>$id))?></a>
</p>