define(["dojo/_base/declare","dijit/form/CheckBox"],
    function(declare,CheckBox){
        /*
         *   摘要:
         *       选择框组件
         */
        return declare("",[CheckBox],{

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