<div class="row paneltitle">
    <h3>投诉单号：<?= $id ?></h3>
</div>

<div class="container-fluid userd">

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

    <dl class="row dl-horizontal"><dt>状态：</dt><dd><?= $status_desc ?></dd></dl>
    <dl class="row dl-horizontal"><dt>严重性：</dt><dd><?= get_label('vl_severity',$severity) ?></dd></dl>
    <dl class="row dl-horizontal"><dt>发生频率：</dt><dd><?= get_label('vl_frequency',$frequency) ?></dd></dl>
    <?php if(_config('category_control')) :?>
        <dl class="row dl-horizontal"><dt>分类：</dt><dd><?= get_label('vl_order_category',$category,$order_type) ?></dd></dl>
    <?php endif;?>
    <dl class="row dl-horizontal"><dt>提交时间：</dt><dd><?= $creation_date ?></dd></dl>
    <hr/>
    <dl class="row dl-horizontal"><dt>标题：</dt><?= $title ?></dd></dl>
    <dl class="row dl-horizontal"><dt>内容：</dt>
        <dd class="contentContainer">
        <?php foreach($contents as $c):?>
            <div class=" " id="content_<?= $c['id']?>">
                <?php
                echo full_name($c['created_by'],check_auth('log_display_fullname',array('ao_true_or_false'=>'TRUE'))) .' '.$c['content'];
                echo ' 时间：'.$c['creation_date'];
                ?>
            </div>
            <br/>
        <?php endforeach;?>
        </dd>
    </dl>
    <hr/>

    <dl class="row dl-horizontal"><dt>
            <?php if(!is_order_locked($status)){?>
                <a href="<?= _url('order','upload_file')?>">上传附件</a>
            <?php }?>
            附件：</dt>
        <dd>
            <?php foreach($addfiles as $f):
                //不同文件类型图标不同doc用word，xls用excel，以此类推，如果未知文件类型，用通用图标
                ?>
                <a href="<?= $f['full_path']?>"><?= $f['file_name']?></a>
                <?= $f['description']?>
            <?php endforeach;?>
        </dd>
    </dl>
    <hr/>
    <dl class="row dl-horizontal"><dt>&nbsp</dt>
        <dd>
            <?php render_form_open('order','reply','null','null','addContent') ?>
            <?php render_form_textarea('content',TRUE);?>
            <input name="id" id="id" type="hidden" value="<?= v('id') ?>"/>
            <?php render_submit_button();?>
            <?php render_form_close() ?>
        </dd>
    </dl>

    <hr/>
    <dl class="row dl-horizontal"><dt>本次投诉联系人：</dt><dd><?= $contact ?></dd></dl>
    <dl class="row dl-horizontal"><dt>手机号码：</dt><dd><?= $mobile_telephone ?></dd></dl>
    <dl class="row dl-horizontal"><dt>公司电话：</dt><dd><?= $phone_number ?></dd></dl>
    <dl class="row dl-horizontal"><dt>公司名称：</dt><dd><?= $full_name?></dd></dl>
    <dl class="row dl-horizontal"><dt>公司地址：</dt><dd><?= $address ?></dd></dl>
    <hr/>
</div>

订单日志
<table>
    <thead>
    <th>日志类型</th>
    <th>内容</th>
    <th>操作时间</th>
    <?php if(check_auth('log_display_fullname',array('ao_true_or_false'=>'TRUE'))):?>
        <th>操作人</th>
        <th>原因</th>
    <?php endif;?>

    </thead>
    <?php foreach($logs as $l):
        ?>
        <tr>
            <td><?= $l['description']?></td>
            <td><?= $l['content']?></td>
            <td><?= related_time($l['creation_date'])?></td>
            <?php if(check_auth('log_display_fullname',array('ao_true_or_false'=>'TRUE'))):?>
                <td><?= $l['created_by']?></td>
                <td><?= $l['reason']?></td>
            <?php endif;?>

        </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript">
    function addContent(data){
        var d = data['content'];
        require(['dojo/dom-construct',"dojo/_base/fx"],function(domConstruct,fx){
            var content = d["created_by"]+"："+d["content"]+"  时间："+d["creation_date"]+"<br/>";
            var node = $(".contentContainer",currentWso().domNode)[0];
            domConstruct.create("div",{class : " ",innerHTML : content,id: "content_"+d["id"]},node);
//            fx.fadeIn({
//                node: "content_"+d["id"]
//            }).play();
        });
    }
</script>