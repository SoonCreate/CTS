<div id="configsIndexGrid"></div>
<script type="text/javascript">
    require(["sckj/DataGrid",
        "gridx/modules/Filter",
        "gridx/modules/filter/QuickFilter"],function(Grid,Filter,QuickFilter){
        var grid ;
        onWsoLoad(function(){
            $ajax.get(url("configs/structure"),{handleAs:"json"}).then(function(structure){
                grid = new Grid({
                    asyncCache : false,
                    pageSize : 10,
                    url : url("configs/data"),
                    structure:structure,
                    autoWidth : false,
                    autoHeight : true,
                    modules : [Filter,QuickFilter],
                    operationColumn : {
                        data : [
                            {url : "configs/edit",label: "<?= label('edit')?>"}
                        ]
                    }
                },"configsIndexGrid");

                grid.startup();
            });

        });
    });
</script>