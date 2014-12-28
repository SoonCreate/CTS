<?= render_form_header('allocate_modules');?>
<?= render_form_open('functions','allocate_modules','_getGridData(this)') ?>
<div id="functionAllocateModulesGrid"></div>
<?= render_form_hidden('lines');?>
<?= render_form_hidden('id',v('id'));?>
<?= render_button_group();?>
<?= render_form_close() ?>
<script type="text/javascript">

    require(["dojo/ready","sckj/DataGrid",
            "gridx/core/model/cache/Sync",
            "dojo/data/ItemFileReadStore",
            "dojo/request"
        ],
        function(ready,Grid,SyncCache,ItemFileReadStore,request){
            ready(function(){
                request.get(url("functions/module_data?function_id=<?= _v('id')?>"),{handleAs : "json"}).then(function(data){
                    var store = new ItemFileReadStore({
                        data : data
                    });
                    var structure = data["structure"];
                    var grid = new Grid({
                        store: store ,
                        structure: structure,
                        selectRowTriggerOnCell: true,
                        selectRowMultiple : true,
                        autoWidth : false,
                        autoHeight : true,
                        id : "functionAllocateModulesGrid",
                        style:"margin-left: 20px;min-width:400px",
                        pageSize : 10
                    },"functionAllocateModulesGrid");
                    grid.startup();
                    //选择
                    var value = data["selected"];
                    for(var i=0;i < value.length;i++){
                        grid.select.row.selectById(value[i]);
                    }
                });
            });

        });

    function _getGridData(form){
        form["lines"].value = dijitObject("functionAllocateModulesGrid").select.row.getSelected().join();
    }

</script>