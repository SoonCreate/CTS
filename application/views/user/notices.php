<!--<div class="container-fluid">-->
<!--    <div class="row">-->
<!--        --><?//= render_button('notice_read_all','_userNoticesRefreshData()') ?>
<!--    </div>-->
<!--    <div id="myNoticeList" class="gridlist"></div>-->
<!--</div>-->


<div id="myNoticeList"></div>

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
                 VirtualVScroller,TouchVScroller){
            ready(function(){

                toolbarAddButton("<?= label('notice_read_all') ?>",_userNoticesRefreshData);

                var restStore = new JsonRest({idProperty: 'id', target:url('user/notice_data'),sortParam: "sortBy"});
                var store = new ObjectStore({objectStore: restStore});
                var pageSize = 13;
                var grid = new Grid({
                    cacheClass : AsyncCache,
                    id : "myNoticeList",
                    store: store ,
                    structure: [
                        {name : "",field : "",width : "50px"},
                        {name : "标题",field : "title",width : "300px",dataType :"string",
                            decorator: function(cellData, rowId, rowIndex){
                                return '<a href="#" onclick="_userNoticesRefreshSingleData(\'' + url('user/notice_show?id='+rowId) + '\')">'+cellData+'</a>';
                            } },
                        {name : "时间",field : "creation_date",width : "160px",dataType :"string"},
                        {name : "操作",field : "",width : "300px"}
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
                    style:"margin-left: 20px"

                },"myNoticeList");

                grid.connect(grid.body, 'onAfterRow', function(row){
                    //参数为row，通过row.node()获取node并修改样式
                    var data = row.rawData();
                    if(data["read_flag"] == "0"){
                        row.node().style.fontWeight = "bold";
                    }

                });

                grid.startup();

                grid.pagination.setPageSize(pageSize);

            });

        });
    //刷新store的数据
    function _userNoticesRefreshData(){
        require(["dojo/store/JsonRest"],function(JsonRest){
            $ajax.get(url('user/notice_read_all'),{handleAs : "json"}).then(function(responce){
                handleResponse(responce,null,function(){
                    refresh_notice_count(0);
                    refresh();
                });
            });
//            var newStore = new JsonRest({idProperty: 'id', target:url('user/notice_data'),sortParam: "sortBy"});
//            grid.refresh(newStore);
        });
    }

    function _userNoticesRefreshSingleData(url){
        refresh_notice_count();
        goto(url);
    }
</script>