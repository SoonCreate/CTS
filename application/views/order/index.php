<!--style type="text/css">
    .orderindex{
        margin: 0;
    }
</style-->
<script type="text/javascript">
    //alert("higs");
    // require(["dojo/dom","dojo/domReady"],function(dom){
    //   console.info("问题list");
    //  var orderindex = dojo.query(".dijitTabContainerLeft-dijitContentPane");
    //  orderindex.addClass("orderindex");
    // dojo.query(".dijitTabContainerLeft-dijitContentPane").style({margin:"0"});
    // });

</script>
<div class="container-fluid">
    <div class="row inline">
        <!--?= lang('title') ?--><input id="title" name="title" data-dojo-type="sckj/form/TextBox" class="leftinput"  /><!- style="width:400px" ->
        <!--?= lang('status') ?-->
        <select  id="status" name="status" data-dojo-type="sckj/form/Select"  trim="true" class="midinput">
            <?= render_options('vl_order_status')?>
        </select>
        <button data-dojo-type="sckj/form/Button" class="rightbtn"  onclick="_createIndexRefreshData()">
            <?= label('search')?>
        </button>
        <!--?php render_form_input('title');?>
        <!--?php render_select_with_options('status','vl_order_status')?>
        <!--?php render_button('refresh','_createIndexRefreshData()');?-->
    </div>
    <div id="myOrdersList" class="gridlist"></div>
</div>

<div id="myOrdersList"></div>

<script type="text/javascript">
    require(["dojo/ready",
            "sckj/Gridx",
            "gridx/core/model/cache/Async",
            "dojo/store/JsonRest",
            "dojo/data/ObjectStore",
            "gridx/modules/Pagination",
            "gridx/modules/pagination/PaginationBar",
            "gridx/modules/ColumnResizer",
            "gridx/modules/VirtualVScroller",
            "gridx/modules/TouchVScroller"  //IPAD支持
        ],
        function(ready,Grid,AsyncCache,JsonRest,ObjectStore,
                 Pagination,
                 PaginationBar,
                 ColumnResizer,
                 VirtualVScroller,
                 TouchVScroller){
            ready(function(){

                var restStore = new JsonRest({idProperty: 'id', target:url('order/order_data'),sortParam: "sortBy"});
                var store = new ObjectStore({objectStore: restStore});
                var pageSize = 10;
                var grid = new Grid({
                    cacheClass : AsyncCache,
                    id : "myOrdersList",
                    store: store ,
                    structure: [

                        {name : "投诉单号",field : "id",width : "80px",dataType :"number",style:"text-align: center"},
//                        {name : "订单类型",field : "order_type",width : "160px",dataType :"string"},
                        <?php if(_config('category_control')){?>
                        {name : "分类",field : "category",width : "140px",dataType :"string"},
                        <?php }?>
                        {name : "标题",field : "title",width : "360px",dataType :"string",
                            decorator: function(cellData, rowId, rowIndex){
                                return '<a href="#" onclick="goto(\'' + url('order/show?id='+rowId) + '\')"><b>'+cellData+'</b></a>';
                            } },
                        {name : "内容概览",field : "content",width : "160px",dataType :"string"},
                        {name : "状态",field : "status",width : "60px",dataType :"string"},
                        {name : "提交时间",field : "creation_date",width : "130px",dataType :"string"}
                    ],
                    pageSize: pageSize,//发送到服务端的条目HTTP header : items=0-19
                    modules : [
                        {
                            moduleClass: Pagination
                        },
                        {
                            moduleClass: PaginationBar,
                            sizes: [20,50, 100],  //显示分页size
                            sizeSeparator: "|"  //分页size之间分割符
                        },
                        ColumnResizer,
                        VirtualVScroller,
                        TouchVScroller
                    ],
//                },
                    autoWidth : false,
                autoHeight : true,
                    style:"margin-left: 20px;"

                },"myOrdersList");

                grid.startup();
                grid.pagination.setPageSize(pageSize);

            });

        });
    //刷新store的数据
    function _createIndexRefreshData(options){
        var params = new Object();
        var title = dijitObject('title');
        var status = dijitObject('status');
        var grid = dijitObject('myOrdersList');
        if(grid){
            if(title != undefined && title.getValue() != ""){
                params.title = title.getValue();
            }

            if(status != undefined && status.getValue() != ""){
                params.status = status.getValue();
            }
            require(["dojo/store/JsonRest"],function(JsonRest){
                var newStore = new JsonRest({idProperty: 'id', target:url('order/order_data',params),sortParam: "sortBy"});
                grid.refresh(newStore);
            });
        }
    }
</script>