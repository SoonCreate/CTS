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
                showRoot: true,
                persist:true,
                autoExpand: true,
                //双击打开
                openOnClick : true,
                //一次只能选单个
                dndParams:['singular'],
                singular : true
                //双击导航栏项目
//                onDblClick : function(item){
//                    //展示工作区
//                    if(! item["children"]){
//                        //如果是用户注销连接则先提示
//                        if(item["url"].toString().indexOf(ciUrl("user","logout")) > 0){
//                            dojoConfirm(res.message.logout,function(){
//                                logout();
//                            },null,"W");
//                        }else{
//                            cp2.set("href",item["url"]);
//                        }
//
//                    }
//                }
            });
            fmGroupTree.addChild(fmTree);
            fmContainer.startup();
            fmContainer.resize();
        };

        _doGroupAction = function(fn){
            var selectedNode = fmTree.selectedItem;
            if(selectedNode){
                if(selectedNode["root"]){
                    dojoConfirm("根目录无法编辑",null,null,null,"W");
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

    });


</script>