<div id="sessionsIndexGrid"></div>
<script type="text/javascript">
    toolBarAddLinkButton("<?= label('kill_all_sessions') ?>",url('sessions/kill_all'),null,true);
    require(["dojo/ready","sckj/DataGrid"], function(ready,Grid){
        ready(function(){
            var grid = new Grid({
                asyncCache : false,
                url : url('sessions/data'),
                operationColumn : {
                    name : "<?= label('operation')?>",
                    width : "500px",
                    data : [
                        {url : "sessions/kill",label: "<?= label('kill_session')?>",noRender:true}
                    ]
                },
                sort : true,
                pageSize : 10,
                autoWidth : false,
                autoHeight : true,
                style:"margin-left: 20px;"

            },"sessionsIndexGrid");

            grid.startup();

        });
    });
</script>