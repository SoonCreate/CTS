<h1>投诉单号：<?= $id ?></h1>

<?php
//如果订单状态为锁定，则不显示工具栏
if(!is_order_locked($status)){?>

<?php if(is_order_allow_next_status($status,'confirmed') && check_order_auth($order_type,'confirmed',$category)){?>
    <a href="<?= _url('order','confirm',array('id'=>$id))?>">投诉内容已确认</a>
<?php }?>

<?php if(is_order_allow_next_status($status,'allocated') && check_order_auth($order_type,'allocated',$category)){?>
<a href="<?= _url('order','dispatcher',array('id'=>$id))?>">分配责任人并确认计划完成日期</a>
<?php }?>

<?php if(is_order_allow_next_status($status,'done') && check_order_auth($order_type,'done',$category)){?>
    <a href="<?= _url('order','done',array('id'=>$id))?>">标志已解决</a>
<?php }?>

    <?php if(is_order_allow_next_status($status,'closed') && check_order_auth($order_type,'closed',$category)){?>
        <a href="<?= _url('order','close',array('id'=>$id))?>">关闭订单</a>
    <?php }?>

<?php if(check_function_auth('order','meeting_create')){ ?>
<a href="<?= _url('order_meeting','index',array('order_id'=>$id)) ?>">会议记录</a>
<?php } ?>


<hr/>

<?php }else{?>
    <?php if(is_order_allow_next_status($status,'reopen') && check_order_auth($order_type,'reopen',$category)){?>
        <a href="<?= _url('order','reopen',array('id'=>$id))?>">重新开启</a>
    <?php }?>
<?php }?>

状态：<?= $status_desc ?><br/>
严重性：<?= get_label('vl_severity',$severity) ?><br/>
发生频率：<?= get_label('vl_frequency',$frequency) ?><br/>
<?php if(_config('category_control')) :?>
分类：<?= get_label('vl_order_category',$category,$order_type) ?><br/>
<?php endif;?>
提交时间：<?= $creation_date ?>
<hr/>
标题：<?= $title ?><br/>
内容：<br/>
<?php foreach($contents as $c):?>
<?php if($c['created_by'] == _sess('uid')) :  echo '投诉人：'.$c['content']; else : echo $c['content'] ;endif; ?><br/>
<?php endforeach;?>
<hr/>

<?php if(!is_order_locked($status)){?>
<a href="<?= _url('order','upload_file')?>">上传附件</a>
<?php }?>
附件：
<?php foreach($addfiles as $f):
    //不同文件类型图标不同doc用word，xls用excel，以此类推，如果未知文件类型，用通用图标
    ?>
    <a href="<?= $f['full_path']?>"><?= $f['file_name']?></a>
    <?= $f['description']?>
<?php endforeach;?>
<hr/>
<form id="order_reply" method="post" action="<?= _url('order','reply')?>">
    <textarea id="content" name="content" cols="40" rows="4"></textarea>
    <input name="id" id="id" type="hidden" value="<?= $id ?>"/>
    <button type="submit">提交</button>
</form>
<hr/>
本次投诉联系人：<?= $contact ?><br/>
手机号码：<?= $mobile_telephone ?><br/>
公司电话：<?= $phone_number ?><br/>
公司名称：<?= $full_name?><br/>
公司地址：<?= $address ?><br/>
<hr/>
订单日志
<table>
    <thead>
    <th>日志类型</th>
    <th>内容</th>
    <th>操作时间</th>
    <th>操作人</th>
    <th>原因</th>
    </thead>
    <?php foreach($logs as $l):
        echo $l['log_type'];
        if(check_auth('log_display_control',array('ao_log_type'=>$l['log_type']))){
        ?>
        <tr>
            <td><?= $l['description']?></td>
            <td><?= $l['content']?></td>
            <td><?= related_time($l['creation_date'])?></td>
            <td><?= $l['created_by']?></td>
            <td><?= $l['reason']?></td>
        </tr>
    <?php }
    endforeach;?>
</table>