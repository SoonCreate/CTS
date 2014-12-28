<?= render_select_with_options('role_id','vl_roles')?>
<div id="orderMeetingChooseAnchorGrid"></div>
<script type="text/javascript">

    require(["dojo/ready","sckj/DataGrid",
            "gridx/core/model/cache/Sync",
            "dojo/data/ItemFileReadStore",
            "dojo/request"
        ],
        function(ready,Grid,SyncCache,ItemFileReadStore,request){
            ready(function(){
                request.get(url("order_meeting/user_search_data"),{handleAs : "json"}).then(function(data){
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
                        id : "orderMeetingChooseAnchorGrid",
                        style:"margin-left: 20px;min-width:420px",
                        pageSize : 6
                    },"orderMeetingChooseAnchorGrid");
                    grid.startup();

                });
            });

        });

</script>
