//前端触发后端链接
function goto(url){
    var wso = currentWso();
    if(wso){
        wso.set("href",url);
    }
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
    require(["dijit/registry"],function(registry){
        var worksapce = registry.byId("mainTabContainer");
        if(worksapce){
            wso = worksapce.tablist._currentChild;
        }
    });
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
            handleResponse(response,remoteFail,remoteSuccess,remoteNoBack);
        },function(){
            console.log('remote request error!');
        });
    });
    return false;
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
    require(["dijit/registry"],function(registry){
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

        var toaster = registry.byId("toaster");
        toaster.setContent(message["content"], messageType,5000);
        toaster.show();
    });

}

function addFormAlertLine(lines){
    require(["dojo/dom","dojo/query","dojo/dom-construct","dojo/dom-style"],
        function(dom,query,domConstruct,domStyle){
            var ul = clearFormAlertLine()
            for(var i=0;i<lines.length;i++){
                for (var key in lines[i]) {
                    domConstruct.create("li",{innerHTML :lines[i][key]},ul);
                }
            }
            var o = dom.byId("formalert");
            domStyle.set(o,"display","block");
            //回到锚点
            location.hash="#formalert";
        });
}

function clearFormAlertLine(){
    var ul = new Object;
    require(["dojo/dom","dojo/query","dojo/dom-construct"],
        function(dom,query,domConstruct){
            var o = dom.byId("formalert");
            var nodes = query("ul",o);
            if(nodes.length > 0){
                ul = nodes[0];
                domConstruct.empty(ul);
            }
        });
    return ul;
}

function formAlertclose(){
    require(["dojo/dom","dojo/query","dojo/dom-construct","dojo/dom-style"],
        function(dom,query,domConstruct,domStyle){
            var o = dom.byId("formalert");
            clearFormAlertLine();
            domStyle.set(o,"display","none");
    });
}

function renderValidError(lines){
    require(["dijit/registry"],
        function(registry){
            for(var i=0;i<lines.length;i++){
                for (var key in lines[i]) {
                    var object = registry.byId(key);
                    if(object){
                        object.set("state","Error");
                        //object.displayMessage(errorMessage);
                    }
                }

            }
        });


}
