define(["dojo/_base/declare","dijit/form/RadioButton"],
    function(declare,RadioButton){
        /*
         *   摘要:
         *       选择框组件
         */
        return declare("",[RadioButton],{

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