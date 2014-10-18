define(["dojo/_base/declare", "dijit/form/ValidationTextBox"],
    function(declare,ValidationTextBox){
        /*
         *   摘要:
         *       输入框组件
         */
    return declare("",[ValidationTextBox],{
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
