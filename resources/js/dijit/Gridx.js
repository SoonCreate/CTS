define(["dojo/_base/declare", "gridx/Grid"],
    function(declare,Grid){
        /*
         *   摘要:
         *       富文本编辑框组件
         */
        return declare("",[Grid],{

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