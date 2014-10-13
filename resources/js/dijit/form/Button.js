define(["dojo/_base/declare","dijit/form/Button"],
    function(declare,Button){
        /*
         *   摘要:
         *       按钮组件
         */
        return declare("",[Button],{

            //构造函数重写，id赋值方式
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