<?= render_form_open('report','time_statistics_data','null','null','_refreshData')?>
<?= render_select_with_options('order_type','vl_order_type',true)?>
<?= render_form_input('time_span',true,array(),false,label('day'))?>
<dl class="row dl-horizontal">
    <dt></dt>
    <dd>
        <?= render_button('this_month','_setDateTime(1)')?>
        <?= render_button('last_month','_setDateTime(2)')?>
        <?= render_button('this_year','_setDateTime(3)')?>
    </dd>
</dl>
<?= render_form_datetextbox('from_date',true,array(),false,render_form_timebox('from_time',true,'01','00')) ?>
<?= render_form_datetextbox('to_date',true,array(),false,render_form_timebox('to_time',true,'01','00')) ?>
<?= render_submit_button() ?>
<?= render_form_close() ?>

<h3>Top 10</h3>
<div id="timeStatisticsTopGrid"></div>

<script type="text/javascript">
    require(["dojo/ready", "sckj/DataGrid" ],
        function(ready,DataGrid){
            var topGrid;
            ready(function(){
                topGrid = new DataGrid({
                    id : "timeStatisticsTopGrid",
                    url : url('report/time_statistics_data'),
                    asyncCache : false
                },"timeStatisticsTopGrid");
                topGrid.startup();

            });
            _refreshData = function(data){
                console.info(data);
            };

            //快捷设置日期
            _setDateTime = function(t){
                var from_date = dijitObject("from_date");
                var from_time = dijitObject("from_time");
                var to_date = dijitObject("to_date");
                var to_time = dijitObject("to_time");
                var myDate = new Date();
                var f_time = "T00:00:00";
                var t_time = "T23:59:59";
                var year = myDate.getFullYear();
                var month = myDate.getMonth();
                var f_date,t_date;
                switch(t){
                    case 1 :
                        f_date = year + "-" + month + "-01";
                        t_date = getFirstAndLastMonthDay(year,month);
                        break;
                    case 2 :
                        if(month == 1){
                            month = 12;
                            year = year - 1;
                        }else{
                            month = month - 1;
                        }
                        if(month < 10){
                            month = "0"+month;
                        }
                        console.info(month);
                        f_date = year + "-" + month + "-01";
                        console.info(f_date);
                        t_date = getFirstAndLastMonthDay(year,month);
                        break;
                    case 3 :
                        f_date = year + "-01-01";
                        t_date = year + "-12-31";
                        break;
                }
                from_date.setValue(f_date);
                to_date.setValue(t_date);
                from_time.setValue(f_time);
                to_time.setValue(t_time);
            };
        });
</script>