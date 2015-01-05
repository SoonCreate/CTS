<div id="functionsIndexGrid"></div>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('function_create') ?>",url('functions/create'));

    require(["dojo/ready","sckj/DataGrid",
        "gridx/modules/Filter",
        "gridx/modules/filter/QuickFilter"
    ], function(ready,Grid,Filter,QuickFilter){
        ready(function(){
        var grid = new Grid({
            asyncCache : false,
            url : url('functions/data'),
            structure: [
                {name : "<?= label('function_name')?>",field : "function_name",width : "140px",dataType :"string"},
                {name : "<?= label('description')?>",field : "description",width : "200px",dataType :"string"},
                {name : "<?= label('controller')?>",field : "controller",width : "140px",dataType :"string"},
                {name : "<?= label('action')?>",field : "action",width : "140px",dataType :"string"},
                {name : "<?= label('display_flag')?>",field : "display_flag",width : "80px",dataType :"string"},
                {name : "<?= label('display_class')?>",field : "display_class",width : "80px",dataType :"string",
                    decorator: function(cellData, rowId, rowIndex){
                        return '<i class="' + cellData + ' icon-2x"></i>';
                    }
                }
            ],
            operationColumn : {
                name : "<?= label('operation')?>",
                data : [
                    {url : "functions/edit",label: "<?= label('edit')?>"},
                    {url : "functions/destroy",label: "<?= label('destroy')?>",noRender: true},
                    {url : "functions/allocate_modules",label: "<?= label('allocate_modules')?>"},
                    {url : "functions/variants",label: "<?= label('variant')?>"},
                    {url : "functions/objects",label: "<?= label('objects')?>"}
                ]
            },
            modules : [Filter,QuickFilter],
            pageSize : 10,
            autoWidth : false,
            autoHeight : true,
            style:"margin-left: 20px;"

        },"functionsIndexGrid");

        grid.startup();

        });
    });


</script>