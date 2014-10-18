<?= render_form_header(label('order_number').'  '.$id ) ?>

<div class="container-fluid userd">

    <?php
    //如果订单状态为锁定，则不显示工具栏
    if(!is_order_locked($status)){?>

        <?php if(is_order_allow_next_status($status,'confirmed') && check_order_auth($order_type,'confirmed',$category)){?>
            <button data-dojo-type="sckj/form/Button"><?= render_link(array('order','confirm',array('id'=>$id)),'投诉内容已确认',null,null,true)?></button>
        <?php }?>

        <?php if(is_order_allow_next_status($status,'allocated') && check_order_auth($order_type,'allocated',$category)){?>
            <button data-dojo-type="sckj/form/Button"><?= render_link(array('order','dispatcher',array('id'=>$id)),'分配责任人并确认计划完成日期')?></button>
        <?php }?>

        <?php if(is_order_allow_next_status($status,'done') && check_order_auth($order_type,'done',$category)){?>
            <button data-dojo-type="sckj/form/Button"><?= render_link(array('order','done',array('id'=>$id)),'投诉已解决',null,null,true)?></button>
        <?php }?>

        <?php if(is_order_allow_next_status($status,'closed') && check_order_auth($order_type,'closed',$category)){?>
            <button data-dojo-type="sckj/form/Button"><?= render_link(array('order','close',array('id'=>$id)),'投诉单关闭',null,null,true)?></button>
        <?php }?>

        <?php if(check_function_auth('order','meeting_create')){ ?>
            <button data-dojo-type="sckj/form/Button"><?= render_link(array('order_meeting','index',array('order_id'=>$id)),'会议记录') ?></button>
        <?php } ?>


        <hr/>

    <?php }else{?>
        <?php if(is_order_allow_next_status($status,'reopen') && check_order_auth($order_type,'reopen',$category)){?>
            <button data-dojo-type="sckj/form/Button">
                <?= render_link(array('order','reopen',array('id'=>$id)),'投诉单重新打开',null,null,true)?>
            </button>
        <?php }?>
    <button data-dojo-type="sckj/form/Button">
        <?= render_link(array('order','feedback',array('id'=>$id)),'反馈建议以及评分')?>
    </button>
    <?php }?>

    <dl class="row dl-horizontal"><dt>状态</dt><dd><?= $status_desc ?></dd></dl>
    <dl class="row dl-horizontal"><dt>严重性</dt><dd><?= get_label('vl_severity',$severity) ?></dd></dl>
    <dl class="row dl-horizontal"><dt>发生频率</dt><dd><?= get_label('vl_frequency',$frequency) ?></dd></dl>
    <?php if(_config('category_control')) :?>
        <dl class="row dl-horizontal"><dt>分类</dt><dd><?= get_label('vl_order_category',$category,$order_type) ?></dd></dl>
    <?php endif;?>
    <dl class="row dl-horizontal"><dt>提交时间</dt><dd><?= $creation_date ?></dd></dl>
    <hr/>
    <dl class="row dl-horizontal"><dt>标题</dt><dd><?= $title ?></dd></dl>
    <dl class="row dl-horizontal"><dt>内容</dt>
        <dd class="contentContainer">
        <?php foreach($contents as $c):?>
            <div class="" id="content_<?= $c['id']?>">
                <?php
                echo '<kbd>'.full_name($c['created_by'],check_auth('log_display_fullname',array('ao_true_or_false'=>'TRUE'))) .'</kbd>'.$c['content'];
                echo '<a class="ddtime"> 时间：'.$c['creation_date'].'</a>';
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
            附件</dt>
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
            <?= render_form_open('order','reply','null','null','addContent') ?>
            <?= render_form_textarea('content',TRUE);?>
            <input name="id" id="id" type="hidden" value="<?= v('id') ?>"/>
            <?= render_submit_button();?>
            <?= render_form_close() ?>
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
        var d = data['content'];
        require(['dojo/dom-construct'],function(domConstruct){
            var content = "<kbd>"+d["created_by"]+"</kbd>"+d["content"]+"<a class='ddtime'>时间："+d["creation_date"]+"</a>";
            var node = $(".contentContainer",currentWso().domNode)[0];
            //直接定义class时 IE8不支持，只能事后set
            domConstruct.create("div",{innerHTML : content,id: "content_"+d["id"]},node);
        });
    }
</script>