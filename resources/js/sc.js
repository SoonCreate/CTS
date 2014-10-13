//前端触发后端链接
function goto(target,url){
    var wso = $dijit.byId(target+'_module');
    if(!wso){
        wso = currentWso();
    }
    wso.set("href",url);
    $dijit.byId("mainTabContainer").selectChild(wso,true);
}

function isArray(obj) {
    return Object.prototype.toString.call(obj) === '[object Array]';
}

//刷新当前页
function refreshCurrentPane(){
    var wso = currentWso();
    if(wso){
        wso.refresh();
    }
}

function currentWso(){
    var wso = null;
    var worksapce = $dijit.byId("mainTabContainer");
    if(worksapce){
        wso = worksapce.tablist._currentChild;
    }
    return wso;
}
//form对象，form提交前处理，服务端反馈为报错，服务端反馈为正常，服务端没有返回
function formSubmit(object,beforeSubmit,remoteFail,remoteSuccess,remoteNoBack){
    //钩子 提交前
    if(beforeSubmit){
        beforeSubmit();
    }
    require(["dojo/dom-form","dojo/request"],function(domForm,request){
        request.post(object.action, {
            // Send the username and password
            data: domForm.toObject(object),
            // Wait 2 seconds for a response
            timeout: 2000,
            handleAs : "json"
        }).then(function(response){
            clearCurrentStatus();
            handleResponse(response,remoteFail,remoteSuccess,remoteNoBack);
        },function(){
            console.log('remote request error!');
        });
    });
    return false;
}

//清楚当前错误（dijitTextBoxError）class的dom并清除状态
function clearCurrentStatus(){
    require(["dojo/dom-class"],function(domClass){
        var wso = currentWso();
        var nodes = $(".dijitTextBoxError",wso.domNode);
        for(var i = 0; i<nodes.length;i++){
            var widgetid = nodes[i]["attributes"]["widgetid"]["value"];
            if(widgetid){
                $dijit.byId(widgetid).set("state","");
            }
        }
    });
}

//处理返回值
function handleResponse(response,remoteFail,remoteSuccess,remoteNoBack){
    if(response){
        var errorStatus = false;
        //处理验证信息
        if("validation" in response ){
            errorStatus = true;
            //提示验证消息
            addFormAlertLine(response["validation"]);
            renderValidError(response["validation"]);
        }

        //处理消息
        if("message" in response ){
            for(var i=0;i < response["message"].length;i++){
                var message = response["message"][i];
                if(message["type"] == "E"){
                    errorStatus = true;
                }
                showMessage(message);
            }
        }

        //没有错误的时候才能处理数据和重定向
        if(!errorStatus){
            //处理数据
            if("data" in response ){
                if(remoteSuccess){
                    remoteSuccess(response["data"]);
                }
            }

            //处理跳转
            if("redirect" in response ){
                goto(response["redirect"]);
            }
        }else{
            if(remoteFail){
                remoteFail();
            }
        }
    }else{
        if(remoteNoBack){
            remoteNoBack();
        }
    }


}

function showMessage(message){
    //type of message; possible values in messageTypes enumeration ("message", "warning", "error", "fatal")
    var messageType = "message";
    switch(message["type"]){
        case 'I' :
            messageType = "message";
            break;
        case "E" :
            messageType = "error";
            break;
        case "W" :
            messageType = "warning";
            break;
        default :
            messageType = "message";
            break;
    }

    var toaster = $dijit.byId("toaster");
    toaster.setContent(message["content"], messageType,5000);
    toaster.show();

}

function addFormAlertLine(lines){
    require(["dojo/dom-construct","dojo/dom-style"],
        function(domConstruct,domStyle){
            var ul = clearFormAlertLine()
            for(var i=0;i<lines.length;i++){
                for (var key in lines[i]) {
                    domConstruct.create("li",{innerHTML :lines[i][key]},ul);
                }
            }
            var o = currentAlertPane();
            domStyle.set(o,"display","block");
            //回到锚点
            location.hash="#"+ o.id;
        });
}

function clearFormAlertLine(){
    var ul = new Object;
    require(["dojo/dom-construct"],
        function(domConstruct){
            var o = currentAlertPane();
            var nodes = $("ul",o);
            if(nodes.length > 0){
                ul = nodes[0];
                domConstruct.empty(ul);
            }
        });
    return ul;
}

//当前的form错误提示区域
function currentAlertPane(){
    return  $dom.byId($env.cm+"_formalert");
}

function formAlertclose(){
    require(["dojo/dom-style"],
        function(domStyle){
            var o = currentAlertPane();
            clearFormAlertLine();
            domStyle.set(o,"display","none");
    });
}

function renderValidError(lines){

    for(var i=0;i<lines.length;i++){
        for (var key in lines[i]) {
            var object = dijitObject(key);
            if(object){
                //激活
                //object.focus();
                object.set("state","Error");
                //object.displayMessage(errorMessage);
            }
        }

    }

}

//没有定义好环境，则刷新
function refresh_env(){
    if($env && $env.cm){
        //预加载，加载后动画
        require(["dojo/_base/fx", "dojo/dom-style"], function(baseFx,domStyle){
            baseFx.fadeOut({  //Get rid of the loader once parsing is done
                node: "preloader",
                onEnd: function() {
                    domStyle.set("preloader","display","none");
                }
            }).play();
        });

        //$(".preloader").style("display","none")
        console.log("current module line id : "+$env.cm);
    }else{
        history.go(0);
    }
}

//用于控件的唯一性标识
function fixDijitId(id){
    var rtId = "";
    if($env && $env.cm){
        rtId = $env.cm + "_" + id ;
    }
    return rtId;
}

//效果同js原先的confirm
//content ：弹出框内容 ； callback ： 确认后要执行的内容
function dojoConfirm(content,callback,noback,type){
    require(["sckj/Dialog","dijit/form/Button"],
        function(Dialog,Button){
            //检查如果存在则销毁
            var di = dijit.byId("confirmDialog");
            if(di){
                di.hide();
                di.destroyRecursive();
            }
            switch(type){
                case "E" :
                    //此处可以再渲染
                    content =  "<div class='messageContainer'><img src='resources/images/error.gif' width='60px' height='60px'/>" +
                    "<div class='messageContent'>" + content + "</div></div>";
                    break;
                case "W" :
                    content = "<div class='messageContainer'><img src='resources/images/warning.png' width='60px' height='60px'/>" +
                    "<div class='messageContent'>" +content + "</div></div>";
                    break;
                default :
                    content = "<div class='messageContainer'><div class='messageContent'>" +content + "</div></div>";
                    break;
            }
            var confirmDialog = new Dialog({
                content : content,
                id : "confirmDialog",
                title : "消息",
                onClick : function(){
                    if(type == "I"){
                        this.hide();
                    }
                }
            });
            //IE优化
//            var node = domConstruct.create("div",{class : "confirmButtonGroup"});
            var node = document.createElement('div');
//            node.setAttribute('class', 'confirmButtonGroup');
            node.className = "dijitDialogPaneActionBar";

            //确认按钮
            var okbutton = new Button({
                label : "确认",
                onClick : function(){
                    if(callback){
                        callback();
                    }
                    confirmDialog.hide();
                }
            });
            okbutton.placeAt(node,"last");

            //取消按钮
            var cancelbutton = new Button({
                label : "取消",
                onClick : function(){
                    if(noback){
                        noback();
                    }
                    confirmDialog.hide();
                }
            });
            cancelbutton.placeAt(node,"last");

            confirmDialog.containerNode.appendChild(node);
            confirmDialog.show();
        });

}

//根据id fix之后返回控件对象
function dijitObject(id){
    return $dijit.byId(fixDijitId(id));
}