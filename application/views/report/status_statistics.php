<table>
    <tr>
        <td colspan="2">
            <?= render_select_with_options('order_type','vl_order_type',true,array('onChange'=>'_refreshData(this)'))?>
        </td>
    </tr>
    <tr>
        <td style="width: 550px">
            <div id="Pie">
                <div id="legend_Pie"></div>
                <div id="chart_Pie"></div>
            </div>
        </td>
        <td>
            <div id="statusStatisticsGrid"></div>
        </td>
    </tr>
</table>
<h3>Detail</h3>
<div id="statusStatisticsDetailGrid"></div>

<script type="text/javascript">
    require(["dojo/ready",
            "sckj/DataGrid",
            "dojox/charting/Chart2D",
            "dojox/charting/themes/Dollar",
            // Retrieve the Legend, Tooltip, and MoveSlice classes
            "dojox/charting/action2d/MoveSlice",
            "dojox/charting/action2d/Highlight",
            "dojox/charting/action2d/Tooltip",
            "dojox/charting/widget/Legend",
            //  We want to use Markers
            "dojox/charting/plot2d/Markers",
            "dojo/data/ItemFileWriteStore",
            "dijit/Tooltip"
        ],
        function(ready,DataGrid,Chart2D,Theme,MoveSlice,Highlight,Tooltip,Legend,Markers,ItemFileWriteStore,DijitTooltip){
            //全局变量
            var chart,store,chartData,legend,detailGrid,mag,highLight,toolTip;
            //fix tooltip 刷新仍然存在bug
            _hideToolTip();
            ready(function(){

                $ajax.get(url("report/status_statistics_data"),{handleAs : "json"}).then(function(data){
                    //格式化数据
                    _setData(data);

                    var structure = data["structure"];
                    var detail_structure = data["detail_structure"];

                    var grid = new DataGrid({
                        asyncCache : false,
                        structure : structure,
                        store : store,
                        id : "statusStatisticsGrid",
                        style : "width : 420px;min-height:180px",
                        autoHeight : true,
                        onRowSelect : function(row){
                            mag.reset();
                            var rowIndex = row.index();
                            var evtObjects = chart.getPlot("default")._eventSeries["default"];
                            //渲染效果
                            for(var i=0;i<evtObjects.length;i++){
                                var evt = evtObjects[i];
                                if(i == rowIndex){
                                    //模拟鼠标over
                                    evt.type = "onmouseover";
                                    toolTip.process(evt);
                                }
                                else{
                                    //去除其他的鼠标out
                                    evt.type = "onmouseout";
//                                    toolTip.process({ type: "onmouseout"});
                                }
                                highLight.process(evt);
                                mag.process(evt);
                            }
                            var rowData = row.rawData();
                            detailGrid.refreshByUrl(url("order/order_data?order_type="+dijitObject("order_type").getValue()+"&status="+rowData["status"]));
                        }
                    },"statusStatisticsGrid");

                    grid.startup();

                    detailGrid = new DataGrid({
                        asyncCache : true,
                        structure : detail_structure,
                        id : "statusStatisticsDetailGrid",
                        pageSize : 10,
                        url : url("order/order_data?order_type="+dijitObject("order_type").getValue()),
                        autoHeight : true
                    },"statusStatisticsDetailGrid");
                    detailGrid.startup();

                    // x and y coordinates used for easy understanding of where they should display
                    // Data represents website visits over a week period
                    chart = new Chart2D("chart_Pie");
                    chart.setTheme(Theme);
                    chart.addPlot("default",{
                        type: "Pie",
                        font: "normal normal 10pt Tahoma",
                        fontColor: "#000",
                        labelWiring: "#ccc",
                        radius: 100,
                        labelStyle: "columns",
                        htmlLabels: true,
                        startAngle: -10,
                        markers: true
                    });

                    chart.addSeries("default",chartData);

                    // Highlight!
                    highLight = new Highlight(chart,"default");
                    toolTip = new Tooltip(chart, "default");
                    // Create the slice mover
                    mag = new MoveSlice(chart,"default",{scale : 1.1,shift:5});

                    chart.render();
                    legend = new Legend({chart: chart},"legend_Pie");

                    // Connect an event to the "default" plot
//                    chart.connectToPlot("default", function(evt) {
////                        Use console to output information about the event
//                        console.info("Chart event on default plot!",evt);
//                        console.info("Event type is: ",evt.type);
//                        console.info("The element clicked was: ",evt.element);
//                    });
                });
            });
            _refreshData = function(object){
                $ajax.get(url('report/status_statistics_data?order_type='+object.getValue()),{handleAs : "json"}).then(function(data){
                    _setData(data);
                    dijitObject("statusStatisticsGrid").refresh(store);
                    chart.updateSeries("default",chartData);
                    chart.render();
                    legend.refresh();
                    detailGrid.refreshByUrl(url("order/order_data?order_type="+object.getValue()));
                });
            };
            _setData = function(data){
                store = new ItemFileWriteStore({
                    data : data
                });
                chartData = [];
                for(var i = 0;i < data["items"].length ; i++){
                    chartData.push({y : data["items"][i]["status_count"],text : data["items"][i]["text"],tooltip:data["items"][i]["percent"]  });
                }
            };
            _hideToolTip = function(){
                DijitTooltip.hide(toolTip.aroundRect);
                toolTip.aroundRect = null;
            };
        });
</script>