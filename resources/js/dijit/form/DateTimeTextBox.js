define(["dojo/_base/declare",
        "dijit/form/DateTextBox",
        "dijit/form/TimeTextBox",
        "dijit/_WidgetBase",
        "dijit/_TemplatedMixin",
        "dojo/dom-construct",
        "dojo/text!./templates/DateTimeTextBox.html"],
    function(declare,DateTextBox,TimeTextBox,_WidgetBase,_TemplatedMixin,domConstruct,template){

    return declare("",[_WidgetBase, _TemplatedMixin],{
        templateString: template,
        postName : "",
        dateTextBox : null,
        timeTextBox : null,
        constructor : function(args){
            //默认属性
            if(args.name != undefined || args.id != undefined ){
                if(!args.id){
                    args.id = fixDijitId(args.name);
                }else{
                    args.id = fixDijitId(args.id);
                }
                this.postName = args.name;
            }
            this.inherited(arguments);

        },
        postCreate : function(){
            var o = this;
            var date = new Date(this.value);
            this.dateTextBox = new DateTextBox({
                id : this.id+"_date",
                name : this.name+"_date",
                value : date,
                constraints: {
                    datePattern : "y-M-d"
                },
                onChange : function(){
                    o._fixValue();
                }
            });
            this.timeTextBox = new TimeTextBox({
                id : this.id+"_time",
                name : this.name+"_time",
                value : date,
                constraints: {
                    timePattern : "HH:mm:ss"
                },
                onChange : function(){
                    o._fixValue();
                }
            });
            domConstruct.place(this.dateTextBox.domNode,this.domNode);
            domConstruct.place(this.timeTextBox.domNode,this.domNode);

            this.inherited(arguments);
        },

        startup : function () {
            this.dateTextBox.startup();
            this.timeTextBox.startup();
            this.inherited(arguments);
        },

        //重写销毁函数，避免刷新时对象已存在错误
        destroy : function(){
            this.dateTextBox.destroy();
            this.timeTextBox.destroy();
            this.inherited(arguments);
        },

        //将date和time整合在一起
        _fixValue : function(){
            var date = this.dateTextBox.focusNode.value;
            var time = this.timeTextBox.focusNode.value;
            if(date && time){
                this.focusNode.value = date + " " + time;
                this._set("value",this.focusNode.value);
            }else{
                this.focusNode.value = "";
                this._set("value","")
            }
        },

        _set : function(attr, value){
            var oldValue = this._get("value");
            //同时设置
            if(attr == "value" && value != oldValue){
                var date = new Date(value);
                this.dateTextBox.set("value",date);
                this.timeTextBox.set("value",date);
            }
            if(attr == "state"){
                this.dateTextBox.set(attr, value);
                this.timeTextBox.set(attr, value);
            }
            this.inherited(arguments);
        }
    });
});