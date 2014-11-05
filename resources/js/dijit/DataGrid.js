define(["dojo/_base/declare", "gridx/Grid",
        "gridx/core/model/cache/Sync",
        "dojo/data/ItemFileWriteStore",
        "gridx/core/model/cache/Async",
        "dojo/store/JsonRest",
        "dojo/data/ObjectStore",
        "dojo/request",
        "gridx/modules/Pagination",
        "gridx/modules/pagination/PaginationBar",
        "gridx/modules/ColumnResizer",
        "gridx/modules/VirtualVScroller",
        "gridx/modules/TouchVScroller",
        "gridx/modules/IndirectSelectColumn",
        //抬头全选按钮和onSelect无法兼得
        'gridx/modules/select/Row',
        "gridx/modules/extendedSelect/Row",
        "dojo/dom-style"
    ],
    function(declare,Gridx,Sync,ItemFileWriteStore,Async,JsonRest,ObjectStore,
             request,Pagination,PaginationBar,ColumnResizer,VirtualVScroller,TouchVScroller,
             IndirectSelectColumn,
             selectSingleRow,
             selectMultipleRow,
             domStyle){
        return declare("",[Gridx],{
            constructor : function(args){
                /*
                *operationColumn : {
                 name : "操作",
                 field : "",
                 width : "300px",
                 dataType :"string",
                 data : [
                 {url : "functions/edit",label: "<?= label('edit')?>",param : "id",target : null,noRender: false},
                 {url : "functions/destroy",label: "<?= label('destroy')?>",param : "id",target : null,noRender: true},
                 {url : "functions/allocate_modules",label: "<?= label('allocate_modules')?>",param : "id",target : null,noRender: false},
                 {url : "functions/objects",label: "<?= label('objects')?>",param : "id",target : null,noRender: false}
                 ]
                 },
                *
                * */
                if(args.structure && args.operationColumn){
                    var oc = args.operationColumn;
                    //默认值
                    if(oc["name"] == undefined){
                        oc["name"] = "操作";
                    }
                    if(oc["width"] == undefined){
                        oc["width"] = "300px";
                    }
                    if(oc["dataType"] == undefined){
                        oc["dataType"] = "string";
                    }
                    args.structure.push({
                        field : oc["field"],
                        name : oc["name"],
                        width : oc["width"],
                        dataType : oc["dataType"],
                        style : "opacity:0",
                        decorator : function(cellData, rowId, rowIndex){
                            var value = "";
                            var data = oc["data"];
                            for(var i=0;i<data.length;i++){
                                if(data[i]["param"]  == undefined){
                                    data[i]["param"] = "id";
                                }
                                if(data[i]["target"] == undefined){
                                    data[i]["target"] = null;
                                }
                                if(data[i]["noRender"] == undefined){
                                    data[i]["noRender"] = false;
                                }
                                if(i != 0){
                                    value = value + "&nbsp;|&nbsp;";
                                }
                                value = value + '<a href="#" onclick="goto(\'' + url(data[i]["url"] + '?'+ data[i]["param"] +'='+rowId) + '\','+
                                data[i]["target"] +','+ data[i]["noRender"] +')">' + data[i]["label"] + '</a>';
                            }
                            return value;
                        }
                    });
                }

                //默认属性
                if(args.name != undefined || args.id != undefined ){
                    if(!args.id){
                        args.id = fixDijitId(args.name);
                    }else{
                        args.id = fixDijitId(args.id);
                    }
                }

                args.modules = [ColumnResizer,VirtualVScroller,TouchVScroller];
                ////是否启用分页
                if(args.pageSize != undefined || args.pagination){
                    args.modules.push(Pagination);
                    args.modules.push(PaginationBar);
                }

                //single,multiple
                //抬头全选按钮和onSelect无法兼得
                if(args.selectRowMultiple){
                    args.modules.push(IndirectSelectColumn);
                }
                if(args.hasOnSelect){
                    args.modules.push(selectSingleRow);
                }else{
                    //多选单选
                    if(args.selectRowMultiple){
                        args.modules.push(selectMultipleRow);
                    }else{
                        args.modules.push(selectSingleRow);
                    }
                }

                //数据缓存方式
                if(args.asyncCache){
                    args.cacheClass = Async;

                }else{
                    args.cacheClass = Sync;
                }

                //先赋予空数据
                var store = new ItemFileWriteStore({
                    data : {"identifier":"id","items":[]}
                });
                args.store = store;

                //加入一列操作列


                //默认属性
                this.inherited(arguments);
            },

            postCreate : function () {
                var grid = this;
                //数据
                if(this.asyncCache){
                    //异步
                    var restStore = new JsonRest({idProperty: 'id', target:this.url,sortParam: "sortBy"});
                    grid.setStore(restStore);
                    grid._setSelected();
                }else{
                    request.get(this.url,{handleAs : "json"}).then(function(data){
                        var store = new ItemFileWriteStore({
                            data : data
                        });
                        grid.setStore(store);
                        if("structure" in data){
                            grid.setColumns(data["structure"]);
                        }
                        grid._setSelected();
                    });
                }
                this.inherited(arguments);
            },

            startup : function () {
                this.inherited(arguments);
                if(this.pageSize){
                    this.pagination.setPageSize(this.pageSize);
                }
            },

            //重新刷新gird，如果没有指定数据源则刷新本身
            refresh : function(store){
                if(!store){
                    store = this.store;
                }
                this.model.clearCache();
                //delete this.model.store;
                this.model.setStore(store);
                this.body.refresh();
            },

            //鼠标漂浮
            onRowMouseOver : function(arguments){
                if(this.operationColumn){
                    domStyle.set(this.cell(arguments.rowIndex,this.columnCount() - 1).node(),"opacity","1");
                }
            },

            onRowMouseOut : function(arguments){
                if(this.operationColumn){
                    domStyle.set(this.cell(arguments.rowIndex,this.columnCount() - 1).node(),"opacity","0");
                }
            },

            onRowTouchEnd : function(){

            },
            //设置初始选择项目
            _setSelected : function () {
                if(this.targetDijit){
                    var value = this.targetDijit.getValue();
                    value = value.split(',');
                    for(var i=0;i<value.length;i++){
                        this.select.row.selectById(value[i]);
                    }
                }
            }


        });

    });