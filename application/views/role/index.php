<div id="roleIndexGrid"></div>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('role_create') ?>",url('role/create'));
    toolbarAddButton("<?= label('role_copy') ?>",function(){
        goto(url('role/copy_from'));
    },"<?= label('create_role_as_copy') ?>");

    require(["dojo/ready","sckj/DataGrid"], function(ready,Grid){
        ready(function(){
            var grid = new Grid({
                asyncCache : false,
                url : url('role/data'),
                structure: [
                    {name : "<?= label('role_name')?>",field : "role_name",width : "240px",dataType :"string"},
                    {name : "<?= label('description')?>",field : "description",width : "300px",dataType :"string"}
                ],
                operationColumn : {
                    data : [
                        {url : "role/edit",label: "<?= label('edit')?>"},
                        {url : "role/destroy",label: "<?= label('destroy')?>",noRender: true},
                        {url : "role/allocate_users",label: "<?= label('allocate_users')?>",param :"role_id"},
                        {url : "role/choose_functions",label: "<?= label('choose_functions')?>",param :"role_id"},
                        {url : "role/profile",label: "<?= label('auth_object')?>",param :"role_id"}
                    ]
                },
                pageSize : 10,
                autoWidth : false,
                autoHeight : true,
                style:"margin-left: 20px;"

            },"roleIndexGrid");

            grid.startup();

        });
    });
</script>