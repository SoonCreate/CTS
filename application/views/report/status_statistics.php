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
            "dojo/data/ItemFileWriteStore"
        ],
        function(ready,DataGrid,Chart2D,Theme,MoveSlice,Highlight,Tooltip,Legend,Markers,ItemFileWriteStore){
            //全局变量
            var chart,store,chartData,legend,detailGrid;

            ready(function(){

                $ajax.get(url("report/status_statistics_data"),{handleAs : "json"}).then(function(data){
                    //格式化数据
                    _setData(data);

                    var structure = data["structure"];

                    var grid = new DataGrid({
                        asyncCache : false,
                        structure : structure,
                        store : store,
                        id : "statusStatisticsGrid",
                        selectRowMultiple : false,
                        selectRowTriggerOnCell: true,
                        style : "width : 420px;min-height:180px",
                        autoHeight : true
                    },"statusStatisticsGrid");


                    grid.connect(grid.select.row, 'onSelected', function(row){
                        _refreshDetailData(row);
                    });

                    grid.startup();

                    detailGrid = new DataGrid({
                        asyncCache : true,
                        structure : detail_structure,
                        id : "statusStatisticsDetailGrid",
                        pageSize : 10
                    },"statusStatisticsGrid");

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

                    chart.addSeries("sc",chartData);

                    // Highlight!
                    new Highlight(chart,"default");
                    new Tooltip(chart, "default");
                    // Create the slice mover
                    var mag = new MoveSlice(chart,"default");

                    chart.render();
                    legend = new Legend({chart: chart},"legend_Pie");
                });
            });
            _refreshData = function(object){
                $ajax.get(url('report/status_statistics_data?order_type='+object.getValue()),{handleAs : "json"}).then(function(data){
                    _setData(data);
                    dijitObject("statusStatisticsGrid").refresh(store);
                    chart.updateSeries("sc",chartData);
                    chart.render();
                    legend.refresh();
                    detailGrid.clear();
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
            _refreshDetailData = function(){

            }
        });
</script>