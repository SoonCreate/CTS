define(["dojo/_base/declare", "dijit/form/Select"],
    function(declare,Select){
        /*
         *   摘要:
         *       选择下拉菜单组件
         */
        return declare("",[Select],{

            constructor : function(args){
                //默认属性
                if(args.name != undefined || args.id != undefined ){
                    if(!args.id){
                        args.id = fixDijitId(args.name);
                    }else{
                        args.id = fixDijitId(args.id);
                    }
                }
                this.inherited(arguments);

            }

        });

    });