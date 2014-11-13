<!--style type="text/css">
    .orderindex{
        margin: 0;
    }
</style-->
<script type="text/javascript">
    //alert("higs");
    // require(["dojo/dom","dojo/domReady"],function(dom){
    //   console.info("问题list");
    //  var orderindex = dojo.query(".dijitTabContainerLeft-dijitContentPane");
    //  orderindex.addClass("orderindex");
    // dojo.query(".dijitTabContainerLeft-dijitContentPane").style({margin:"0"});
    // });

</script>
<div class="container-fluid">
    <div class="row inline">
        <input id="title" name="title" data-dojo-type="sckj/form/TextBox" class="leftinput"  /><!- style="width:400px" ->

        <select  id="status" name="status" data-dojo-type="sckj/form/Select"  trim="true" class="midinput">
            <?= render_options_by_array(_v('status')) ?>
        </select>

        <button data-dojo-type="sckj/form/Button" class="rightbtn"  onclick="_createIndexRefreshData()">
            <?= label('search')?>
        </button>

    </div>
    <div id="myOrdersList" class="gridlist"></div>
</div>

<script type="text/javascript">
    require(["dojo/ready","sckj/DataGrid"],function(ready,Grid){
        var grid ;
        ready(function(){

            grid = new Grid({
                asyncCache : true,
                id : "myOrdersList",
                pageSize : 10,
                url : url("order/order_data?order_type=<?= _v('order_type')?>"),
                structure: [
                    {name : "投诉单号",field : "id",width : "80px",dataType :"number",style:"text-align: center"},
                    {name : "投诉单类型",field : "order_type",width : "120px",dataType :"string"},
                    <?php if(_config('category_control')){?>
                    {name : "分类",field : "category",width : "120px",dataType :"string"},
                    <?php }?>
                    {name : "标题",field : "title",width : "300px",dataType :"string",
                        decorator: function(cellData, rowId, rowIndex){
                            return '<a href="#" onclick="goto(\'' + url('order/show?id='+rowId) + '\')"><b>'+cellData+'</b></a>';
                        } },
                    {name : "内容概览",field : "content",width : "160px",dataType :"string"},
                    {name : "状态",field : "status",width : "60px",dataType :"string"},
                    {name : "提交时间",field : "creation_date",width : "130px",dataType :"string"}
                ],
                autoWidth : false,
                autoHeight : true,
                style:"margin-left: 20px;",
                onRowSelect : function(row){
                    console.info(row);
                }

            },"myOrdersList");

            grid.startup();

        });

        _createIndexRefreshData = function () {
            var params = new Object();
            var title = dijitObject('title');
            var status = dijitObject('status');

            params.order_type = "<?= _v('order_type')?>";

            if(title != undefined && title.getValue() != ""){
                params.title = title.getValue();
            }

            if(status != undefined && status.getValue() != ""){
                params.status = status.getValue();
            }
            //刷新数据
            grid.refreshByUrl(url('order/order_data',params));
        };

});
</script>