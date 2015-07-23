<div class="container-fluid">
    <div id="userManageGrid" class="gridlist"></div>
</div>

<script type="text/javascript">
    toolBarAddLinkButton("<?= label('user_create') ?>",url('user/create'));

    require(["sckj/DataGrid",
        "gridx/modules/Filter",
        "gridx/modules/filter/QuickFilter"],function(Grid,Filter,QuickFilter){
        var grid ;
        onWsoLoad(function(){
            $ajax.get(url("user/structure"),{handleAs:"json"}).then(function(structure){
                grid = new Grid({
                    asyncCache : false,
                    pageSize : 10,
                    url : url('user/data'),
                    structure:structure,
                    autoWidth : false,
                    autoHeight : true,
                    modules : [Filter,QuickFilter],
                    operationColumn : {
                        data : [
                            {url : "user/admin_edit",label: "<?= label('edit')?>"},
                            {url:"user/initial_password",label: "<?= label('initial_password')?>",noRender : true,noRenderThen:"_refreshGrid"},
                            {url : "user/choose_roles",label: "<?= label('choose_roles')?>"}
                        ]
                    }
                },"userManageGrid");

                grid.startup();
            });

        });

        _refreshGrid = function () {
            grid.refresh();
        }
    });


</script>