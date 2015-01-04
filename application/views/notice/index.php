<div class="container-fluid">
    <?= render_select_with_options('message_type','vl_message_type',true,array('onChange'=>'_refreshNoticeGridData(this)'))?>
    <div id="noticeList"></div>
</div>

<script type="text/javascript">

    require(["dojo/ready","sckj/DataGrid"],function(ready,Grid){
        var grid ;
        var input = dijitObject('message_type');
        var message_type = "";
        if(input != undefined){
            message_type = input.getValue();
        }
        ready(function(){
            $ajax.get(url("notice/structure",{message_type : message_type}),{handleAs:"json"}).then(function(structure){
                grid = new Grid({
                    asyncCache : true,
                    id : "noticeList",
                    pageSize : 10,
                    url : url("notice/data",{message_type : message_type}),
                    structure:structure,
                    autoWidth : false,
                    autoHeight : true
                },"noticeList");

                grid.startup();
            });

        });

        _refreshNoticeGridData = function(object){
            $ajax.get(url("notice/structure",{message_type : object.value}),{handleAs:"json"}).then(function(structure){
                grid.setColumns(structure);
                grid.refreshByUrl(url("notice/data",{message_type : object.value}));
            });
        }
    });

</script>