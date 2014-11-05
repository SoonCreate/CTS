define(["dojo/_base/declare", "dijit/form/ValidationTextBox",
        "dojo/has", // has("touch")
        "dojo/keys", // keys.DOWN_ARROW keys.ENTER keys.ESCAPE
        "dojo/_base/lang", // lang.hitch lang.isFunction
        "dojo/on",
        "dojo/touch",
        "dojo/dom-style",
        "dojo/text!./templates/ScTextBox.html"],
    function(declare,ValidationTextBox,has,keys,lang,on,touch,domStyle,template){

    return declare("",[ValidationTextBox],{
        //配置vl参数默认值
        vlDialogOptions : {
            valuelistName : null,
            parentSegmentValue : null,
            allValue : false,
            selectRowMultiple : true,
            pagination : false,
            pageSize : 10,
            valueSegment : "id"
        },
        gridDialogOptions : {
            title : "请选择",
            structure : null,
            dataUrl : null,
            selectRowMultiple : true,
            pagination : false,
            pageSize : 10,
            valueSegment : "id",
            onSelect : function () {

            }
        },
        //默认是值列表
        isValuelistDialog : true,

        templateString: template,
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

        },
        postCreate: function(){
            // summary:
            //		set up nodes and connect our mouse and keyboard events

            this.inherited(arguments);

            //如果设置
            if(this.vlDialogOptions.valuelistName || this.gridDialogOptions.dataUrl){
                var keyboardEventNode = this.focusNode || this.domNode;
                this.own(
                    on(this._buttonNode, touch.press, lang.hitch(this, "_onMouseDown")),
                    on(this._buttonNode, "click", lang.hitch(this, "_onClick"))
                    //,
                    //on(keyboardEventNode, "keydown", lang.hitch(this, "_onKey")),
                    //on(keyboardEventNode, "keyup", lang.hitch(this, "_onKeyUp"))
                );
            }else{
                //隐藏按钮
                domStyle.set(this._buttonNode,"display","none");
            }

        },
        _onMouseDown: function(/*Event*/ e){
            // summary:
            //		Callback when the user mousedown/touchstart on the arrow icon.

            if(this.disabled || this.readOnly){
                return;
            }

            // Prevent default to stop things like text selection, but don't stop propagation, so that:
            //		1. TimeTextBox etc. can focus the <input> on mousedown
            //		2. dropDownButtonActive class applied by _CssStateMixin (on button depress)
            //		3. user defined onMouseDown handler fires
            //
            // Also, don't call preventDefault() on MSPointerDown event (on IE10) because that prevents the button
            // from getting focus, and then the focus manager doesn't know what's going on (#17262)
            if(e.type != "MSPointerDown" && e.type != "pointerdown"){
                e.preventDefault();
            }

            this._docHandler = this.own(on(this.ownerDocument, touch.release, lang.hitch(this, "_onMouseUp")))[0];
        },

        _onMouseUp: function(/*Event?*/ e){

        },

        _onClick: function(/*Event*/ e){
            // The drop down was already opened on mousedown/keydown; just need to stop the event
            //if(this._stopClickEvents){
            //    e.stopPropagation();
            //    e.preventDefault();
            //}
            if(this.vlDialogOptions.valuelistName){
                var o = this.vlDialogOptions;
                vlGridDialog(o.valuelistName,o.parentSegmentValue,o.allValue, o.valueSegment,
                    o.selectRowMultiple,this,o.pagination,o.pageSize);
            }else{
                if(this.gridDialogOptions.dataUrl){
                    var o = this.gridDialogOptions;
                    gridDialog(o.title, o.structure, o.dataUrl, o.valueSegment, o.selectRowMultiple,this, o.pagination, o.pageSize, o.onSelect)
                }
            }

        }

    });
});