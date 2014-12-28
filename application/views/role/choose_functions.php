<?= render_form_open('role','choose_functions','_getGridData(this)') ?>
<div id="roleChooseFunctionGrid"></div>
<?= render_form_hidden('lines');?>
<?= render_form_hidden('role_id',v('role_id'));?>
<?= render_button_group();?>
<?= render_form_close() ?>
<script type="text/javascript">

    require(["dojo/ready","sckj/DataGrid",
            "dojo/data/ItemFileReadStore",
            "dojo/request"
        ],
        function(ready,Grid,ItemFileReadStore,request){
            ready(function(){
                request.get(url("role/function_data?role_id=<?= _v('role_id')?>"),{handleAs : "json"}).then(function(data){
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
                        id : "roleChooseFunctionGrid",
                        style:"margin-left: 20px;min-width:400px",
                        pageSize : 10
                    },"roleChooseFunctionGrid");
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
        form["lines"].value = dijitObject("roleChooseFunctionGrid").select.row.getSelected().join();
    }

</script>