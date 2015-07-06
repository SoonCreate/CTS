<div id="fmContainer"></div>
<script type="text/javascript">
    require(["dijit/layout/BorderContainer",
        "dojox/layout/ContentPane",
        "dijit/Tree",
        "dojo/data/ItemFileReadStore",
        "dijit/tree/ForestStoreModel"],function(BorderContainer,ContentPane,Tree,ItemFileReadStore,ForestStoreModel){

        var fmContainer,fmGroupTree,fmWorkSpace,fmTree;

        onWsoLoad(function(){
            _buildLayout();
        });

        _buildLayout = function(){
            fmContainer = new BorderContainer({
                id : "fmContainer",
                style : "width:100%;height:100%"
            },"fmContainer");

            //左边导航
            fmGroupTree = new ContentPane({
                id : "fmGroupTree",
                region: "left",
                splitter:true,
                style :"width:15%"
            });
//            cp1.set("class","navPane");
            fmContainer.addChild(fmGroupTree);

            //右边内容区域
            fmWorkSpace = new ContentPane({
                region: "center",
                id : "fmWorkSpace",
                href : url("form/create")
            });
//            cp2.set("class","centerPane");
            fmContainer.addChild(fmWorkSpace);

            //获取导航栏数据
            var treeStore = new ItemFileReadStore({
                url : url("form/form_tree")
            });

            //存储模块
            var treeModel = new ForestStoreModel({
                store: treeStore,
                root : true,
                rootId : '',
                rootLabel : "Root",
                childrenAttrs : [ "children" ]
            });

            fmTree = new Tree({
                model: treeModel,
                showRoot: false,
                persist:true,
//                autoExpand: true,
                //双击打开
                openOnClick : true,
                //一次只能选单个
                dndParams:['singular'],
                singular : true,
                //双击导航栏项目
                onDblClick : function(item){
                    //判断是否为表单
                    if("form_id" in item){
                        _doFormAction(function(item){
                            fmWorkSpace.set("href",url("form/edit",{id : item["form_id"]}));
                        });
                    }else{
                        _doGroupAction(function(item){
                            fmWorkSpace.set("href",url("form/form_group_edit",{id : item["group_id"]}));
                        });
                    }
                }
            });
            fmGroupTree.addChild(fmTree);
            fmContainer.startup();
            fmContainer.resize();
        };

        _doGroupAction = function(fn){
            var selectedNode = fmTree.selectedItem;
            if(selectedNode){
                if(selectedNode["root"]){
                    dojoConfirm("无法对根目录操作",null,null,null,"W");
                }else{
                    //判断是否为表单类型
                    if("form_id" in selectedNode){
                        dojoConfirm("当前选择的类型为[表单]，无法操作！",null,null,null,"W");
                    }else{
                        fn(selectedNode);
                    }
                }
            }else{
                dojoConfirm("请至少选择一个节点！",null,null,null,"W");
            }
        };

        _doFormAction = function(fn){
            var selectedNode = fmTree.selectedItem;
            if(selectedNode){
                if(selectedNode["root"]){
                    dojoConfirm("无法对根目录操作",null,null,null,"W");
                }else{
                    //判断是否为表单类型
                    if("form_id" in selectedNode){
                        fn(selectedNode);
                    }else{
                        dojoConfirm("当前选择的类型为[分组]，无法操作！",null,null,null,"W");

                    }
                }
            }else{
                dojoConfirm("请至少选择一个节点！",null,null,null,"W");
            }
        };

        //插入功能按钮
        toolbarAddButton("创建组", function () {
            fmWorkSpace.set("href",url("form/form_group_create"));
        });

        toolbarAddButton("编辑组", function () {
            _doGroupAction(function(selectedNode){
                fmWorkSpace.set("href",url("form/form_group_edit",{id : selectedNode["group_id"]}));
            });

        });

        toolbarAddButton("删除组", function () {
            _doGroupAction(function(selectedNode){
                goto(url("form/form_group_destroy",{id : selectedNode["group_id"]}),null,true,true,"是否删除分组？");
            });
        });

        //插入功能按钮
        toolbarAddButton("创建表单", function () {
            var selectedNode = fmTree.selectedItem;
            if(selectedNode){
                if(selectedNode["root"]){
                    fmWorkSpace.set("href",url("form/create"));
                }else{
                    //判断是否为表单类型
                    if("group_id" in selectedNode){
                        fmWorkSpace.set("href",url("form/create",{group_id : selectedNode["group_id"]}));
                    }else{
                        fmWorkSpace.set("href",url("form/create"));

                    }
                }
            }else{
                fmWorkSpace.set("href",url("form/create"));
            }

        });

        toolbarAddButton("编辑表单", function () {
            _doFormAction(function(selectedNode){
                fmWorkSpace.set("href",url("form/edit",{id : selectedNode["form_id"]}));
            });

        });

        toolbarAddButton("删除表单", function () {
            _doFormAction(function(selectedNode){
                goto(url("form/destroy",{id : selectedNode["form_id"]}),null,true,true,"是否删除表单？");
            });
        });

        toolbarAddButton("表单字段", function () {
            _doFormAction(function(selectedNode){
                fmWorkSpace.set("href",url("form/fields",{id : selectedNode["form_id"]}));
            });
        });

    });


</script>