<div id="functionsIndexGrid">
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('function_create') ?>",url('functions/create'));
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

                request.get(url('functions/data'),{handleAs : "json"}).then(function(data){
                    var store = new ItemFileReadStore({
                        data : data
                    });
                    var grid = new Grid({
                        cacheClass : SyncCache,
                        store: store ,
                        structure: [
                            {name : "功能名",field : "function_name",width : "140px",dataType :"string"},
                            {name : "描述",field : "description",width : "200px",dataType :"string"},
                            {name : "控制器",field : "controller",width : "140px",dataType :"string"},
                            {name : "函数",field : "action",width : "140px",dataType :"string"},
                            {name : "前端显示",field : "display_flag",width : "80px",dataType :"string"},
                            {name : "显示样式",field : "display_class",width : "80px",dataType :"string",
                                decorator: function(cellData, rowId, rowIndex){
                                    if(cellData != ""){
                                        return '<i class="' + cellData + ' icon-2x"></i>';
                                    }else{
                                        return '<i class="icon-tasks icon-2x"></i>'
                                    }
                                }
                            },
                            {name : "操作",field : "id",width : "300px",dataType :"number",
                                decorator: function(cellData, rowId, rowIndex){
                                    var value = '<a href="#" onclick="goto(\'' + url('functions/edit?id='+rowId) + '\')"><?= label("edit")?></a>';
                                    value = value + "&nbsp;|&nbsp;";
                                    value = value + '<a href="#" onclick="goto(\'' + url('functions/destroy?id='+rowId) + '\',null,true)"><?= label("destroy")?></a>';
                                    value = value + "&nbsp;|&nbsp;";
                                    value = value + '<a href="#" onclick="goto(\'' + url('functions/allocate_modules?id='+rowId) + '\')"><?= label("allocate_modules")?></a>';
                                    value = value + "&nbsp;|&nbsp;";
                                    value = value + '<a href="#" onclick="goto(\'' + url('functions/objects?id='+rowId) + '\')"><?= label("objects")?></a>';
                                    return value;
                                }}

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

                    },"functionsIndexGrid");

                    grid.startup();
//                    grid.pagination.setPageSize(pageSize);

                });
            });
        });

</script>