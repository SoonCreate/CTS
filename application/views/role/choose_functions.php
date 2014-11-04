<?= render_form_header('choose_functions');?>
<?= render_form_open('role','choose_functions','_getGridData(this)') ?>
<div id="roleChooseFunctionGrid"></div>
<?= render_form_hidden('lines');?>
<?= render_form_hidden('role_id',v('role_id'));?>
<?= render_button_group();?>
<?= render_form_close() ?>
<script type="text/javascript">

    require(["dojo/ready","sckj/Gridx",
            "gridx/core/model/cache/Sync",
            "dojo/data/ItemFileReadStore",
            "dojo/request",
            "gridx/modules/Pagination",
            "gridx/modules/pagination/PaginationBar",
            "gridx/modules/ColumnResizer",
            "gridx/modules/VirtualVScroller",
            "gridx/modules/TouchVScroller",  //IPAD支持
            "gridx/modules/IndirectSelectColumn",
            //抬头全选按钮和onSelect无法兼得
            'gridx/modules/select/Row',
            "gridx/modules/extendedSelect/Row"
        ],
        function(ready,Grid,SyncCache,ItemFileReadStore,request,
                 Pagination,
                 PaginationBar,
                 ColumnResizer,
                 VirtualVScroller,
                 TouchVScroller,
                 IndirectSelectColumn,
                 selectSingleRow,
                 selectMultipleRow){
            ready(function(){
                request.get(url("role/function_data?role_id=<?= _v('role_id')?>"),{handleAs : "json"}).then(function(data){
                    var store = new ItemFileReadStore({
                        data : data
                    });
                    var modules = [
                        ColumnResizer,
                        VirtualVScroller,
                        TouchVScroller,
                        IndirectSelectColumn,
                        Pagination,
                        PaginationBar,
                        selectMultipleRow
                    ];

                    var structure = [
                        {field : "module_name",name:"所属模块",width: "160px"},
                        {field : "module_desc",name:"模块描述",width: "160px"},
                        {field : "function_name",name:"功能名",width: "160px"},
                        {field : "function_desc",name:"功能描述",width: "160px"},
                    ];

                    var grid = new Grid({
                        cacheClass : SyncCache,
                        store: store ,
                        structure: structure,
                        modules : modules,
                        selectRowTriggerOnCell: true,
                        selectRowMultiple : true,
                        autoWidth : false,
                        autoHeight : true,
                        id : "roleChooseFunctionGrid",
                        style:"margin-left: 20px;min-width:400px"
                    },"roleChooseFunctionGrid");
                    grid.startup();
                    grid.pagination.setPageSize(10);
                    var value = data["selected"];
                    for(var i=0;i < value.length;i++){
                        grid.select.row.selectById(value[i]);
                    }
                });
            });

        });

    function _getGridData(form){
        form["lines"].value = dijitObject("roleChooseFunctionGrid").select.row.getSelected().join();
    }

</script>