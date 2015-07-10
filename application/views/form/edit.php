<?= render_form_header('form_edit');?>
<div class="container-fluid userd">
    <?= render_form_open('form','edit') ?>
    <?= render_form_input('form_name',true,true)?>
    <?php $this->load->view('form/_form');?>
    <?= render_form_hidden('id')?>
    <?= render_form_close() ?>
</div>
<div id="FormUIFieldsGrid"></div>
<script type="text/javascript">
    require(["sckj/DataGrid","dojo/dom-style","dojo/dom-attr","dojox/layout/ContentPane"],
        function(Grid,domStyle,domAttr,ContentPane){
        var grid = new Grid({
            asyncCache : false,
            url : url('form/field_data?id=<?= v('id') ?>'),
            structure: [
                {name : "字段名",field : "field_name",width:"160px",dataType :"string"},
                {name : "描述",field : "label",width:"160px",dataType :"string"},
                {name : "类型",field : "field_type",dataType :"string"},
                {name : "长度",field : "field_size",dataType :"number"},
                {name : "必输",field : "required_flag",dataType :"number"},
                {name : "隐藏",field : "hidden_flag",dataType :"number"},
                {name : "失效",field : "disabled_flag",dataType :"number"},
                {name : "默认值",field : "default_value",dataType :"string"},
                {name : "控件",field : "control",dataType :"string"}
            ],
            operationColumn : {
                width : "200px",
                data : [
                    {url : "form/field_edit",label: "编辑",param:"id",onClick : "_fieldEdit(this);"},
                    {url : "form/field_destroy",label: "删除",noRender: true,param:"id"}
                ]
            },
            pageSize : 10,
            autoWidth : false,
            autoHeight : true,
            afterRefresh : function (store) {
                //设置行显示效果
                store.fetch({
                    onItem : function(item){
                        if(item['inactive'] == 1){
                            $("*",grid.row(item['id']).node()).forEach(function(node){
                                domStyle.set(node,"text-decoration","line-through");
                            });
                        }
                    }
                });
            }

        },"FormUIFieldsGrid");
        grid.startup();

        _fieldEdit  = function(e){
            $dijit.byId("fmWorkSpace").set("href", url("form/field_edit?id="+domAttr.get(e,"rowid")));
        }
    });
</script>