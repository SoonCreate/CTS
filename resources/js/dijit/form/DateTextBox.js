define(["dojo/_base/declare","dijit/form/DateTextBox"],
    function(declare,DateTextBox){
        /*
         *   摘要:
         *             时间选择框
         *             */
        return declare("",[DateTextBox],{

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