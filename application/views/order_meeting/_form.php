<?= render_form_input('title',TRUE);?>
<?= render_form_datetextbox('start_date',TRUE,array(),false,render_form_timebox('start_time'));?>
<?= render_form_datetextbox('end_date',TRUE,array(),false,render_form_timebox('end_time'));?>
<?= render_form_input('site',TRUE);?>
<?= render_form_input('anchor',TRUE);?>
<?= render_form_input('recorder');?>
<dl class="row dl-horizontal">
    <dt><?= render_label('actor')?></dt>
    <dd><input name="actor" data-dojo-type="sckj/form/ScTextBox" trim="true"
               data-dojo-props = "hasButton:true,_onClick:_onActorClick"  required value="<?= _v('actor')?>"/></dd>
    <dd></dd>
</dl>
<?= render_form_textarea('discuss') ?>
<?= render_form_input_data('order_id',_url('order_meeting','choose_orders_data',array('id'=>_v('order_id'))),true,false,true,true)?>
<?= render_button_group()?>
<script type="text/javascript">
    function _onActorClick(){
//        require(["dojox/layout/ContentPane"],function(ContentPane){
//            var cp = new ContentPane({
//                href : url("order_meeting/user_search"),
//                id : "orderMeetingChooseAnchorContentPane"
//            });
//            dojoConfirm(cp,"参与者")
//        });
        require(["sckj/Gridx","gridx/core/model/cache/Sync",
            "dojo/data/ItemFileReadStore",
            "gridx/modules/Tree",
            "gridx/modules/IndirectSelectColumn",
            "gridx/modules/extendedSelect/Row",
            "gridx/modules/VirtualVScroller"
        ], function (Grid,syncCache,ItemFileReadStore,Tree,IndirectSelectColumn,ExtendedSelectRow,VirtualVScroller) {
            $ajax.get(url("order_meeting/user_search_data"),{handleAs:"json"}).then(function (data) {
                var store = new ItemFileReadStore({
                    data : data
                });
                store.hasChildren = function(id, item){
                    return item && store.getValues(item, 'children').length;
                };
                store.getChildren = function(item){
                    return store.getValues(item, 'children');
                };
                var grid = new Grid({
                    cacheClass : syncCache,
                    modules : [
                        Tree,
                        IndirectSelectColumn,
                        ExtendedSelectRow,
                        VirtualVScroller
                    ],
                    selectRowTriggerOnCell: true,
                    treeNested: true,
                    store : store,
                    structure : [{field : "description",name: "条目",width : "400px"}]
                });
                grid.startup();

                var actorTextBox = dijitObject('actor');

                //初始化选择
                var value = actorTextBox.getValue().split(",");
                var items = store._arrayOfAllItems;
                for(var a = 0;a < items.length;a++){
                    if(in_array(items[a]["description"].toString(),value)){
                        grid.select.row.selectById(items[a]["id"].toString());
                    }
                }

                dojoConfirm(grid,'参与者',function(){
                    var full_names = [];
                    var ids = grid.select.row.getSelected();
                    for(var i = 0 ;i < ids.length ; i++){
                        //获取名称
                        if(ids[i].indexOf("user_") == 0){
                            var rowData = grid.row(ids[i]).rawData();
                            var desc = rowData["description"];
                            //排除重复项
                            if(!in_array(desc,full_names)){
                                full_names.push(desc);
                            }
                        }
                    }
                    actorTextBox.set("value",full_names.join());
                });
            });

        });

    }
</script>
