define(["dojo/_base/declare","dijit/form/SimpleTextarea"],
    function(declare,SimpleTextarea){
        /*
         *   摘要:
         *       按钮组件
         */
        return declare("",[SimpleTextarea],{

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