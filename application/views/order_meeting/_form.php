<?= render_form_input('title',TRUE);?>
<?= render_form_datetextbox('start_date',TRUE,array(),false,render_form_timebox('start_time'));?>
<?= render_form_datetextbox('end_date',TRUE,array(),false,render_form_timebox('end_time'));?>
<?= render_form_input('site',TRUE);?>
<?= render_form_input('anchor',TRUE);?>
<?= render_form_input('recorder');?>
<?= render_form_input('actor',TRUE);?>
<?= render_form_textarea('discuss');?>
<?= render_form_input('order_id',TRUE,array('title'=>'以英文“,”分隔可关联多个投诉单'))?>
<?= render_button_group(array(render_button('choose_order','_showOrderSelectDialog()','normal')))?>

<script type="text/javascript">
    function _showOrderSelectDialog(){
        require(["dojo/ready",
                "sckj/Gridx",
                "gridx/core/model/cache/Sync",
                "dojo/data/ItemFileReadStore",
                "dojo/request",
                "gridx/modules/Pagination",
                "gridx/modules/pagination/PaginationBar",
                "gridx/modules/ColumnResizer",
                "gridx/modules/VirtualVScroller",
                "gridx/modules/TouchVScroller",  //IPAD支持
                "gridx/modules/IndirectSelectColumn",
                "gridx/modules/extendedSelect/Row"
            ],
            function(ready,Grid,SyncCache,ItemFileReadStore,request,
                     Pagination,
                     PaginationBar,
                     ColumnResizer,
                     VirtualVScroller,
                     TouchVScroller,
                     IndirectSelectColumn,
                     selectRow){
                ready(function(){

                    request.get(url('order_meeting/choose_orders?id=<?= _v('order_id')?>'),{handleAs : "json"}).then(function(data){
                        var store = new ItemFileReadStore({
                            data : data
                        });
                        var grid = new Grid({
                            cacheClass : SyncCache,
                            store: store ,
                            structure: [
                                {name : "订单号",field : "id",width : "80px",dataType :"string"},
                                {name : "标题",field : "title",width : "280px",dataType :"string"},
                                {name : "内容概要",field : "content",width : "180px",dataType :"string"},
                                {name : "投诉人",field : "created_by",width : "120px",dataType :"string"},
                                {name : "创建时间",field : "creation_date",width : "140px",dataType :"string" }

                            ],
                            modules : [
                                Pagination,
                                PaginationBar,
                                ColumnResizer,
                                VirtualVScroller,
                                TouchVScroller,
                                IndirectSelectColumn,
                                selectRow
                            ],
                            selectRowTriggerOnCell: true,
//                },
                            autoWidth : false,
                            autoHeight : true,
                            style:"margin-left: 20px;"

                        },"orderShowLogsGrid");

                        grid.startup();
                        grid.pagination.setPageSize(10);
                        grid.select.row.selectById(<?= _v('order_id')?>);
                        dojoConfirm(grid,"<?= label('choose_order')?>",function(){
                            dijitObject("order_id").set("value",grid.select.row.getSelected().join());
                        });
                    });
                });
            });
    }
</script>
