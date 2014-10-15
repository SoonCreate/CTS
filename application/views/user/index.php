<div id="userManageGrid"></div>

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

                var restStore = new JsonRest({idProperty: 'id', target:url('user/user_data'),sortParam: "sortBy"});
                var store = new ObjectStore({objectStore: restStore});
                var pageSize = 10;
                var grid = new Grid({
                    cacheClass : AsyncCache,
                    id : "userManageGrid",
                    store: store ,
                    structure: [
                        {name : "用户名",field : "username",width : "160px",dataType :"string" },
                        {name : "是否失效",field : "inactive_flag",width : "160px",dataType :"string" },
                        {name : "操作",field : "inactive_flag",width : "300px",dataType :"string",
                            decorator: function(cellData, rowId, rowIndex){
                                var value =  '<a href="#" onclick="goto(\'' + url('user/admin_edit?id='+rowId) + '\')"><?= label("edit")?></a>'+
                                '|<a href="#" onclick="_userIndexRefreshData(\'' + url('user/initial_password?id='+rowId) + '\')"><?= label("initial_password")?></a>';
                                if(cellData == 1){
                                    value = value + '|<a href="#" onclick="_userIndexRefreshData(\'' + url('user/change_status?id='+rowId) + '\')"><?= label("active")?></a>';
                                }else{
                                    value = value + '|<a href="#" onclick="_userIndexRefreshData(\'' + url('user/change_status?id='+rowId) + '\')"><?= label("inactive")?></a>';
                                }
                                return value;
                            } }
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
                    autoWidth : true,
                    autoHeight : true,
                    style:"margin-left: 20px"

                },"userManageGrid");

                grid.startup();

                grid.pagination.setPageSize(pageSize);

            });

        });
    //刷新store的数据
    function _userIndexRefreshData(url){
        require(["dojo/store/JsonRest"],function(JsonRest){
            $ajax.get(url,{handleAs : "json"}).then(function(responce){
                handleResponse(responce,null,function(){
                    dijitObject('userManageGrid').refresh();
                });
            });
        });
    }
</script>