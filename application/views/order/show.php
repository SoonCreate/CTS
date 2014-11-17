<div class="row paneltitle"><h3><?= label('order_number').'  '.$id  ?></h3></div>
<div class="container-fluid userd">
    <div class="row">
        <?= render_order_button_group($id,$order_type,$status)?>

        <?php if(check_function_auth('order_meeting','index')){ ?>
            <?= render_link_button(array('order_meeting','index',array('order_id'=>$id)),label('order_meeting')) ?>
        <?php } ?>
    </div>
    <hr/>
    <dl class="row dl-horizontal"><dt><?= label('order_type')?></dt><dd><?= get_label('vl_order_type',$order_type); ?></dd></dl>
    <?php if(_config('category_control')) :?>
        <dl class="row dl-horizontal"><dt><?= label('category')?></dt><dd><?= get_label('vl_order_category',$category,$order_type) ?></dd></dl>
    <?php endif;?>
    <?php if(check_auth('log_display_fullname',array('ao_true_or_false'=>'TRUE'))){?>
        <dl class="row dl-horizontal"><dt><?= label('leader')?></dt><dd><?= full_name($leader_id) ?></dd></dl>
        <dl class="row dl-horizontal"><dt><?= label('manager')?></dt><dd><?= full_name($manager_id) ?></dd></dl>
        <dl class="row dl-horizontal"><dt><?= label('plan_complete_date')?></dt><dd><?= $plan_complete_date ?></dd></dl>
    <?php }?>
    <dl class="row dl-horizontal"><dt><?= label('status')?></dt><dd><?= $status_desc ?></dd></dl>
    <dl class="row dl-horizontal"><dt><?= label('severity')?></dt><dd><?= get_label('vl_severity',$severity) ?></dd></dl>
    <dl class="row dl-horizontal"><dt><?= label('frequency')?></dt><dd><?= get_label('vl_frequency',$frequency) ?></dd></dl>
    <dl class="row dl-horizontal"><dt><?= label('submit_date')?></dt><dd><?= $creation_date ?></dd></dl>
    <hr/>
    <dl class="row dl-horizontal"><dt><?= label('title')?></dt><dd><?= $title ?></dd></dl>
    <dl class="row dl-horizontal"><dt><?= label('content')?></dt>
        <dd class="contentContainer">
            <ul class="commentList">
            <?php foreach($contents as $c):?>
                <li class="item cl" id="content_<?= $c['id']?>">
                    <a href="#"><img width="48" height="48" class="comment-avatar" alt="" src="<?= base_url() ?>resources/images/avatar-default-S.gif"></a>

                    <div class="comment-main">
                <?php
                echo '<header class="comment-header"><div class="comment-meta"><a class="comment-author" href="#">
                '.full_name($c['created_by'],!check_auth('log_display_fullname',array('ao_true_or_false'=>'TRUE'))) .'</a> '.
                    label('comment_at').' <time>'.$c['creation_date'].'</time></div></header><div class="comment-body"><p>'.$c['content'].'</p></div>';

                ?>
                </div>
            </li>
            <?php endforeach;?>
            </ul>
        </dd>
    </dl>

    <hr/>
    <?= render_form_open('order','reply','null','null','addContent') ?>

    <?= render_form_textarea('content',TRUE);?>
    <input name="id" id="id" type="hidden" value="<?= v('id') ?>"/>

    <dl class="row dl-horizontal"><dt>&nbsp;</dt>
        <dd>
            <?= render_submit_button();?>

        </dd>
    </dl>
    <?= render_form_close() ?>

    <hr/>

    <dl class="row dl-horizontal"><dt>
            <?php if(!is_order_locked($status)){?>
                <a href="#" onclick="_orderUploadDialog()"><?= label('upload_file')?></a>
            <?php }?>
            <?= label('attachment')?></dt>
        <dd>
            <?php foreach($addfiles as $f):
                //不同文件类型图标不同doc用word，xls用excel，以此类推，如果未知文件类型，用通用图标
                echo render_file_link($f);
                ?>
                &nbsp;&nbsp;&nbsp;<?= $f['description']?><br/>
            <?php endforeach;?>
        </dd>
    </dl>
    <hr/>
    <dl class="row dl-horizontal"><dt><?= label('contact') ?></dt><dd><?= $contact ?></dd></dl>
    <dl class="row dl-horizontal"><dt><?= label('mobile_telephone') ?></dt><dd><?= $mobile_telephone ?></dd></dl>
    <dl class="row dl-horizontal"><dt><?= label('phone_number') ?></dt><dd><?= $phone_number ?></dd></dl>
    <dl class="row dl-horizontal"><dt><?= label('full_name') ?></dt><dd><?= $full_name?></dd></dl>
    <dl class="row dl-horizontal"><dt><?= label('address') ?></dt><dd><?= $address ?></dd></dl>
    <hr/>
</div>

<?= render_form_header('order_logs') ?>
<div id="orderShowLogsGrid"></div>
<script type="text/javascript">

    require(["dojo/ready","sckj/DataGrid"], function(ready,Grid){
        ready(function(){
            var grid = new Grid({
                asyncCache : false,
                url : url('order/log_data?id=<?=$id?>'),
                pageSize : 10,
                autoWidth : false,
                autoHeight : true,
                style:"margin-left: 20px;"

            },"orderShowLogsGrid");

            grid.startup();

        });
    });



    function addContent(data){
        refresh_notice_count();
        refresh();
//        var d = data['content'];
//        require(['dojo/dom-construct'],function(domConstruct){
//            var content = "<kbd>"+d["created_by"]+"</kbd>"+d["content"]+"<a class='ddtime'>时间："+d["creation_date"]+"</a>";
//            var node = $(".contentContainer",currentWso().domNode)[0];
//            console.info(node);
//            //直接定义class时 IE8不支持，只能事后set
//            domConstruct.create("div",{innerHTML : content,id: "content_"+d["id"]},node);
//        });
    }

    function _orderUploadDialog(){
        require(["dojox/layout/ContentPane","dojo/io/iframe"],function(ContentPane,iframe){
            var cp = new ContentPane({
                href : url("order/upload_file?id=<?= _v('id')?>"),
                id : "uploadFileContentPane"
            });
            cp.startup();
            dojoConfirm(cp,"文件上传",function(){
                iframe.send({
                    form: "upload_file",
                    method: "POST",
                    timeOut: 2000,
                    handleAs: "json",
                    url : url("order/upload_file")
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