<div class="container-fluid">
    <div id="userManageGrid" class="gridlist"></div>
</div>

<script type="text/javascript">
    toolBarAddLinkButton("<?= label('user_create') ?>",url('user/create'));

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
                        {name : "<?= label('username')?>",field : "username",width : "140px",dataType :"string" },
                        {name : "<?= label('full_name')?>",field : "full_name",width : "200px",dataType :"string" },
                        {name : "<?= label('email')?>",field : "email",width : "160px",dataType :"string",
                            decorator: function(cellData, rowId, rowIndex){
                                if(cellData != null){
                                    return '<a href="mailto:' + cellData + '">' + cellData + ' </a>'; //IE8奇葩bug，加入空格正常显示数据
                                }else{
                                    return "";
                                }
                            }
                        },
                        {name : "<?= label('contact')?>",field : "contact",width : "100px",dataType :"string" },
                        {name : "<?= label('sex')?>",field : "sex",width : "60px",dataType :"string" },
                        {name : "<?= label('mobile_telephone')?>",field : "phone_number",width : "120px",dataType :"number" },
                        {name : "<?= label('operation')?>",field : "inactive_flag",width : "300px",dataType :"string",
                            decorator: function(cellData, rowId, rowIndex){
                                var value =  '<a href="#" onclick="goto(\'' + url('user/admin_edit?id='+rowId) + '\')"><?= label("edit")?></a>'+
                                '&nbsp;|&nbsp;<a href="#" onclick="_userIndexRefreshData(\'' + url('user/initial_password?id='+rowId) + '\')"><?= label("initial_password")?></a>';
                                if(cellData == 1){
                                    value = value + '&nbsp;|&nbsp;<a href="#" onclick="_userIndexRefreshData(\'' + url('user/change_status?id='+rowId) + '\')"><?= label("active")?></a>';
                                }else{
                                    value = value + '&nbsp;|&nbsp;<a href="#" onclick="_userIndexRefreshData(\'' + url('user/change_status?id='+rowId) + '\')"><?= label("inactive")?></a>';
                                }
                                value = value + '&nbsp;|&nbsp;<a href="#" onclick="goto(\'' + url('user/choose_roles?id='+rowId) + '\')"><?= label("choose_roles")?></a>'
                                return value;
                            } },
                        {name:"",field:""}
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

                },"userManageGrid");

                grid.startup();

                grid.pagination.setPageSize(pageSize);

            });

        });
    //刷新store的数据
    function _userIndexRefreshData(url){
        require(["dojo/store/JsonRest"],function(JsonRest){
            dojoConfirm("是否确定执行此操作？",null,function(){
                $ajax.get(url,{handleAs : "json"}).then(function(responce){
                    handleResponse(responce,null,function(){
                        dijitObject('userManageGrid').refresh();
                    });
                });
            });
        });
    }
</script>