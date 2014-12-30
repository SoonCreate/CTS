<div id="myNoticeList"></div>

<script type="text/javascript">

    toolbarAddButton("<?= label('notice_read_all') ?>",_userNoticesRefreshData);

    function _userNoticesRefreshData(){
        $ajax.get(url('user/notice_read_all'),{handleAs : "json"}).then(function(responce){
            handleResponse(responce,null,function(){
                refresh_notice_count(0);
                //刷新store的数据
                refresh();
            });
        });
    }

    require(["dojo/ready","sckj/DataGrid"],function(ready,Grid){
        var grid ;
        ready(function(){
            $ajax.get(url("user/notice_structure"),{handleAs:"json"}).then(function(structure){
                grid = new Grid({
                    asyncCache : true,
                    id : "myNoticeList",
                    pageSize : 13,
                    url : url("user/notice_data"),
                    structure:structure,
                    autoWidth : false,
                    autoHeight : true,
                    style:"margin-left: 20px;",
                    onRowSelect : function(row){
                        goto(url('user/notice_show?id='+row.id))
                    }
                },"myNoticeList");

                grid.connect(grid.body, 'onAfterRow', function(row){
                    //参数为row，通过row.node()获取node并修改样式
                    var data = row.rawData();
                    if(data["read"] == "0"){
                        row.node().style.fontWeight = "bold";
                    }

                });

                grid.startup();
            });

        });

    });

</script>