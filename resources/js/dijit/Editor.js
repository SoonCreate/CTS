define(["dojo/_base/declare", "dijit/Editor"],
    function(declare,Editor){
        /*
         *   摘要:
         *       富文本编辑框组件
         */
        return declare("",[Editor],{

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