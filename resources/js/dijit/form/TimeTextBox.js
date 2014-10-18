define(["dojo/_base/declare","dijit/form/TimeTextBox"],
    function(declare,TimeTextBox){
        /*
         *   摘要:
         *             时间选择框
         *             */
        return declare("",[TimeTextBox],{

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