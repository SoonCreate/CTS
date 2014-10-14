<link rel="stylesheet" href="/dojo/gridx/resources/claro/Gridx.css" />
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
            "gridx/modules/VirtualVScroller"
        ],
        function(ready,Grid,AsyncCache,JsonRest,ObjectStore,
                 Pagination,
                 PaginationBar,
                 ColumnResizer,
                 VirtualVScroller){
            ready(function(){

                var restStore = new JsonRest({idProperty: 'id', target:url('order/order_data/'),sortParam: "sortBy"});
                var store = new ObjectStore({objectStore: restStore});
                var pageSize = 20;
                var grid = new Grid({
                    cacheClass : AsyncCache,
                    id : "myOrdersList",
                    store: store ,
                    structure: [
                        {name : "投诉单号",field : "id",width : "160px",dataType :"number"},
                        {name : "订单类型",field : "order_type",width : "160px",dataType :"string"},
                        {name : "分类",field : "category",width : "120px",dataType :"string"},
                        {name : "状态",field : "status",width : "160px",dataType :"string"},
                        {name : "标题",field : "title",width : "160px",dataType :"string"},
                        {name : "内容概览",field : "content",width : "160px",dataType :"string"}
                    ],
                    pageSize: pageSize,//发送到服务端的条目HTTP header : items=0-19
                    modules : [
                        {
                            moduleClass: Pagination,
                            initialPage: 0//20 //初始化显示在第几页
                        },
                        {
                            moduleClass: PaginationBar,
                            sizes: [20,50, 100],  //显示分页size
                            sizeSeparator: "|"  //分页size之间分割符
                        },
                        ColumnResizer,
                    VirtualVScroller
                    ],
//                },
                    autoWidth : true,
//                autoHeight : true,
                    style:"margin-left: 20px;height:400px"

                },"myOrdersList");

                grid.startup();
                grid.pagination.setPageSize(pageSize);

            });
        });
</script>