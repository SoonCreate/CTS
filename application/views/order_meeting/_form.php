<?= render_form_input('title',TRUE);?>
<?= render_form_datetextbox('start_date',TRUE,array(),false,render_form_timebox('start_time'));?>
<?= render_form_datetextbox('end_date',TRUE,array(),false,render_form_timebox('end_time'));?>
<?= render_form_input('site',TRUE);?>
<?= render_form_input('anchor',TRUE);?>
<?= render_form_input('recorder');?>
<?= render_form_input('actor',TRUE);?>
<?= render_form_textarea('discuss');?>
<?= render_form_input('order_id',TRUE,array('title'=>'以英文“,”分隔可关联多个投诉单'))?>
<?= render_button_group(array(render_button('choose_order','_showOrderSelectDialog()','normal')))?>

<script type="text/javascript">
    function _showOrderSelectDialog(){
        require(["dojo/ready"],function(ready){
            ready(function(){
                var structure = [
                    {name : "订单号",field : "id",width : "80px",dataType :"string"},
                    {name : "标题",field : "title",width : "280px",dataType :"string"},
                    {name : "内容概要",field : "content",width : "180px",dataType :"string"},
                    {name : "投诉人",field : "created_by",width : "120px",dataType :"string"},
                    {name : "创建时间",field : "creation_date",width : "140px",dataType :"string" }

                ];
                gridDialog("<?= label('choose_order')?>",structure,
                    url('order_meeting/choose_orders?id=<?= _v('order_id')?>'),true,dijitObject("order_id"));
            });
        });

    }
</script>
