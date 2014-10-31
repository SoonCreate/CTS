<?= render_form_header(label('order_number').'  '.$id ) ?>

<div class="container-fluid userd">
    <div class="row">
        <?= render_order_button_group($id,$order_type,$status)?>
    <?php
    //如果订单状态为锁定，则不显示工具栏
    if(!is_order_locked($status)){?>

        <?php if(check_order_auth($order_type,'confirmed',$category)){?>

            <?php if(is_order_allow_next_status($order_type,$status,'confirmed')){?>
            <?= render_link_button(array('order','confirm',array('id'=>$id)),'投诉内容已确认',null,null,true)?>
            <?php }?>

            <?php
            //投诉单未分配处理人，可修改负责人
            if($status == 'confirmed'){?>
                <?= render_link_button(array('order','choose_leader',array('id'=>$id)),'选择投诉的责任人（部门经理）')?>
            <?php }?>

        <?php }?>

        <?php
        //如果为当前投诉单的责任人，则可以分配处理人
        if(is_order_allow_next_status($order_type,$status,'allocated') && check_order_auth($order_type,'allocated',$category) && $leader_id == _sess('uid')){?>
            <?= render_link_button(array('order','dispatcher',array('id'=>$id)),'选择投诉的具体处理人员')?>
        <?php }?>

        <?php
        //必须小于规定的修改次数
        if(check_order_auth($order_type,'done',$category) && $manager_id == _sess('uid') && $pcd_change_times < _config('pcd_change_times') && $status != 'done'){?>
            <?= render_link_button(array('order','pcd_change',array('id'=>$id)),'填写计划完成日期')?>
        <?php }?>

        <?php if(is_order_allow_next_status($order_type,$status,'done') && check_order_auth($order_type,'done',$category)){?>
            <?= render_link_button(array('order','done',array('id'=>$id)),'投诉已解决',null,null,true)?>
        <?php }?>

        <?php if(is_order_allow_next_status($order_type,$status,'closed') && check_order_auth($order_type,'closed',$category)){?>
            <?= render_link_button(array('order','close',array('id'=>$id)),'投诉单关闭',null,null,true)?>
        <?php }?>



    <?php }else{?>
        <?php if(_config('allow_reopen') && is_order_allow_next_status($order_type,$status,'reopen') && check_order_auth($order_type,'reopen',$category)){?>
            <?= render_link_button(array('order','reopen',array('id'=>$id)),'投诉单重新打开',null,null,true)?>
        <?php }?>
        <?php if(_config('feedback_control')){ ?>
            <?= render_link_button(array('order','feedback',array('id'=>$id)),'反馈建议以及评分')?>
        <?php } ?>
    <?php }?>

        <?php if(check_function_auth('order_meeting','index')){ ?>
            <?= render_link_button(array('order_meeting','index',array('order_id'=>$id)),'会议记录') ?>
        <?php } ?>
        <hr/>
    </div>

    <dl class="row dl-horizontal"><dt>投诉单类型</dt><dd><?= get_label('vl_order_type',$order_type); ?></dd></dl>
    <?php if(_config('category_control')) :?>
        <dl class="row dl-horizontal"><dt>分类</dt><dd><?= get_label('vl_order_category',$category,$order_type) ?></dd></dl>
    <?php endif;?>
    <?php if(check_auth('log_display_fullname',array('ao_true_or_false'=>'TRUE'))){?>
        <dl class="row dl-horizontal"><dt>责任人</dt><dd><?= full_name($leader_id) ?></dd></dl>
        <dl class="row dl-horizontal"><dt>处理人</dt><dd><?= full_name($manager_id) ?></dd></dl>
        <dl class="row dl-horizontal"><dt>计划完成日期</dt><dd><?= $plan_complete_date ?></dd></dl>
    <?php }?>
    <dl class="row dl-horizontal"><dt>状态</dt><dd><?= $status_desc ?></dd></dl>
    <dl class="row dl-horizontal"><dt>严重性</dt><dd><?= get_label('vl_severity',$severity) ?></dd></dl>
    <dl class="row dl-horizontal"><dt>发生频率</dt><dd><?= get_label('vl_frequency',$frequency) ?></dd></dl>
    <dl class="row dl-horizontal"><dt>提交时间</dt><dd><?= $creation_date ?></dd></dl>
    <hr/>
    <dl class="row dl-horizontal"><dt>标题</dt><dd><?= $title ?></dd></dl>
    <dl class="row dl-horizontal"><dt>内容</dt>
        <dd class="contentContainer">
            <ul class="commentList">
            <?php foreach($contents as $c):?>
                <li class="item cl" id="content_<?= $c['id']?>">
                    <a href="#"><img width="48" height="48" class="comment-avatar" alt="" src="<?= base_url() ?>resources/images/avatar-default-S.gif"></a>

                    <div class="comment-main">
                <?php
                echo '<header class="comment-header"><div class="comment-meta"><a class="comment-author" href="#">
'.full_name($c['created_by'],!check_auth('log_display_fullname',array('ao_true_or_false'=>'TRUE'))) .'</a> 评论于 <time>'.$c['creation_date'].'</time></div></header><div class="comment-body"><p>'.$c['content'].'</p></div>';

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
                <a href="#" onclick="_orderUploadDialog()">上传附件</a>
            <?php }?>
            附件</dt>
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
    <dl class="row dl-horizontal"><dt>本次投诉联系人</dt><dd><?= $contact ?></dd></dl>
    <dl class="row dl-horizontal"><dt>手机号码</dt><dd><?= $mobile_telephone ?></dd></dl>
    <dl class="row dl-horizontal"><dt>公司电话</dt><dd><?= $phone_number ?></dd></dl>
    <dl class="row dl-horizontal"><dt>公司名称</dt><dd><?= $full_name?></dd></dl>
    <dl class="row dl-horizontal"><dt>公司地址</dt><dd><?= $address ?></dd></dl>
    <hr/>
</div>

<?= render_form_header(label('order_logs')) ?>
<div id="orderShowLogsGrid"></div>
<script type="text/javascript">
    require(["dojo/ready",
            "sckj/Gridx",
            "gridx/core/model/cache/Sync",
            "dojo/data/ItemFileReadStore",
            "dojo/request",
            "gridx/modules/Pagination",
            "gridx/modules/pagination/PaginationBar",
            "gridx/modules/ColumnResizer",
            "gridx/modules/VirtualVScroller",
            "gridx/modules/TouchVScroller"  //IPAD支持
        ],
        function(ready,Grid,SyncCache,ItemFileReadStore,request,
                 Pagination,
                 PaginationBar,
                 ColumnResizer,
                 VirtualVScroller,
                 TouchVScroller){
            ready(function(){

                request.get(url('order/log_data?id=<?=$id?>'),{handleAs : "json"}).then(function(data){
                    var store = new ItemFileReadStore({
                        data : data
                    });
                    var grid = new Grid({
                        cacheClass : SyncCache,
                        id : "orderShowLogsGrid",
                        store: store ,
                        structure: [
                            {name : "日志类型",field : "description",width : "120px",dataType :"string"},
                            {name : "内容",field : "content",width : "300px",dataType :"string"},
                            {name : "原因",field : "reason",width : "240px",dataType :"string"},
                            <?php if(check_auth('log_display_fullname',array('ao_true_or_false'=>'TRUE'))){?>
                                {name : "操作人",field : "created_by",width : "100px",dataType :"string"},
                            <?php }?>
                            {name : "操作时间",field : "creation_date",width : "140px",dataType :"string" }

                        ],
                        modules : [
                            Pagination,
                            PaginationBar,
                            ColumnResizer,
                            VirtualVScroller,
                            TouchVScroller
                        ],
//                },
                        autoWidth : false,
                        autoHeight : true,
                        style:"margin-left: 20px;"

                    },"orderShowLogsGrid");

                    grid.startup();
//                    grid.pagination.setPageSize(pageSize);

                });
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