//前端触发后端链接
function goto(url,target,noRender,noRecord){
    var wso = $dijit.byId('module_'+target);
    if(wso == undefined){
        wso = currentWso();
    }
    if(!noRender){
        if(!noRecord){
            recordWso();
        }
        wso.set("href",url);
        $dijit.byId("mainTabContainer").selectChild(wso,true);
    }else{
        dojoConfirm("是否确定执行此操作？",function(){
            $ajax.get(url,{handleAs : "json"}).then(function(response){
                handleResponse(response,null,function(){
                    refresh();
                });
            });
        });
    }

}

function menu(){
    goto(url('welcome/my_functions?module_id='+$env.mid));
}

function recordWso(url){
    if($env.history == undefined){
        $env.history = new Array();
    }else{
        if($env.history.length == 10){
            $env.history.pop();
        }
    }
    $env.history.unshift({url:currentWso().href,target:$env.mid});
    console.info($env.history);
}

function isURL(str_url){
    var strRegex = "^((https|http|ftp|rtsp|mms)?://)"
        + "?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?" //ftp的user@
        + "(([0-9]{1,3}\.){3}[0-9]{1,3}" // IP形式的URL- 199.194.52.184
        + "|" // 允许IP和DOMAIN（域名）
        + "([0-9a-z_!~*'()-]+\.)*" // 域名- www.
        + "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\." // 二级域名
        + "[a-z]{2,6})" // first level domain- .com or .museum
        + "(:[0-9]{1,4})?" // 端口- :80
        + "((/?)|" // a slash isn't required if there is no file name
        + "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$";
    var re=new RegExp(strRegex);
    //re.test()
    if (re.test(str_url)){
        return true;
    }else{
        return false;
    }
}

function goback(){
    if("history" in $env){
        if($env.history.length > 0 ){
            goto($env.history[0]['url'],$env.history[0]['target'],false,true);
            $env.history.shift();
            console.info($env.history);
        }
    }
}

function refresh(then){
    currentWso().refresh();
    if(then){
        then();
    }
}

function currentGoto(url){
    var wso = currentWso();
    wso.set("href",url);
}

function redirect(url){
    window.location.href = url;
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
        //fix form中有name为action组件时优先调用组件值的情况 20141017
        request.post(object.attributes["action"]["value"], {
            // Send the username and password
            data: domForm.toObject(object),
            // Wait 2 seconds for a response，由于机器性能不同，可能反馈的效率不一，设置5秒以防万一
            timeout: 5000,
            handleAs : "json"
        }).then(function(response){
            clearCurrentStatus();
            handleResponse(response,remoteFail,remoteSuccess,remoteNoBack);
        },function(e){
            showMessage({type : 'E',content : "请求出现未知出错，请联系管理员！"});
            console.log(e);
        });
    });
    return false;
}

//清楚当前错误（dijitTextBoxError）class的dom并清除状态
function clearCurrentStatus(){
    require(["dojo/dom-class"],function(domClass){
        //formAlertclose();
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
            //addFormAlertLine(response["validation"]);
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
            }else{
                if(remoteSuccess){
                    remoteSuccess(response);
                }
            }

            //处理跳转
            if("redirect" in response ){
                if(response["redirect"]["url"] == "goBack"){
                    goback();
                }else{
                    goto(response["redirect"]["url"],response["redirect"]['target']);
                }

            }

            if("dialog" in response){
                require(["sckj/Dialog"],
                    function(Dialog){
                        //检查如果存在则销毁
                        var di = dijit.byId("confirmDialog");
                        if(di){
                            di.hide();
                            di.destroyRecursive();
                        }
                        var confirmDialog = new Dialog({
                            href : response["dialog"]["url"],
                            id : "confirmDialog",
                            title : response["dialog"]["title"],
                            closable : response["dialog"]["closable"]
                        });

                        confirmDialog.show();
                    });

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
            var nodes = $('div[id^="error_"]',currentWso().domNode);
            for(var y=0;y<nodes.length;y++){
                nodes[y].innerHTML = "";
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
                //object.displayMessage(lines[i][key]);
                var wso = currentWso();
                //object.displayMessage("gogo");
                var nodes = $("#error_"+fixDijitId(key),wso.domNode);
                for(var y=0;y<nodes.length;y++){
                    nodes[y].innerHTML = lines[i][key];
                }
            }
        }

    }

}

//没有定义好环境，则刷新
function refresh_env(mid){
    //预加载，加载后动画
    require(["dojo/_base/fx", "dojo/dom-style"], function(baseFx,domStyle){
        if($dom.byId("preloader")){
            baseFx.fadeOut({  //Get rid of the loader once parsing is done
                node: "preloader"
                //,
                //onEnd: function() {
                //    domStyle.set("preloader","display","none");
                //}
            }).play();
        }
    });
    if($env && $env.cm){
        //$(".preloader").style("display","none")
        //console.info($dijit.byId('mainTabContainer'));
        $env.mid = mid;
        console.log("current module line id : "+$env.cm+" mid : "+$env.mid);
    }
}

function onModuleShow(mid){
    $env.mid = mid;
}

//用于控件的唯一性标识
function fixDijitId(id){
    var rtId = "";
    if($env && $env.cm){
        rtId =  id + "_" + $env.cm + "_" + $env.mid ;
    }
    return rtId;
}

//效果同js原先的confirm
//content ：弹出框内容 ； callback ： 确认后要执行的内容
function dojoConfirm(content,title,callback,noback,type){
    require(["sckj/Dialog","dijit/form/Button"],
        function(Dialog,Button){
            //检查如果存在则销毁
            var di = $dijit.byId("confirmDialog");
            if(di){
                di.hide();
            }

            if(title == undefined){
                title = "消息";
            }

            var confirmDialog = new Dialog({
                id : "confirmDialog",
                title : title,
                onClick : function(){
                    if(type == "I"){
                        this.hide();
                    }
                }
            });

            confirmDialog.startup();

            //判断为字符串还是参数
            if(Object.prototype.toString.call(content) != "[object String]"){
                confirmDialog.containerNode.appendChild(content.domNode);
            }else{
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
                        content = "<div class='messageContent'>" +content + "</div>";
                        break;
                }
                confirmDialog.set("content",content);
            }

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
            okbutton.set("class","success");
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

function closeDialog(){
    var di = $dijit.byId("confirmDialog");
    if(di){
        di.hide();
    }
}

function closeDialogAndRefresh(){
    closeDialog();
    refresh();
}

//根据id fix之后返回控件对象
function dijitObject(id){
    return $dijit.byId(fixDijitId(id));
}

//刷新未读消息数量:后续等待优化，采用ajax长轮询
function refresh_notice_count(n){
    if(n){
        $dom.byId("scbadge").innerHTML = n;
    }else{
        $ajax.get(url('welcome/notice_need_to_read'),{handleAs : "text"}).then(function(data){
            $dom.byId("scbadge").innerHTML = data;
        });
    }

}

//工具栏加入功能按钮
function toolbarAddButton(label,onclick){
    require(["dijit/ToolbarSeparator","sckj/form/Button"], function (ToolbarSeparator,Button) {
        var handle = dojo.connect(currentWso(),"onDownloadEnd",function(){
            //在工具栏添加一个功能按钮
            var toolBar = dijitObject('toolbar');
            console.info(toolBar);
            if(toolBar){
                var ts = new ToolbarSeparator();
                var bt = new Button({
                    label : label,
                    onClick : onclick
                });
                ts.startup();
                bt.startup();
                toolBar.addChild(ts);
                toolBar.addChild(bt);
                dojo.disconnect(handle);
            }
        });
    });

}