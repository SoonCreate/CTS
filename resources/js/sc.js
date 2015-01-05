//前端触发后端链接
function goto(url,target,noRender,noRecord,message){
    var wso = $dijit.byId('module_'+target);
    if(wso == undefined){
        wso = currentWso();
    }
    //wso都没有定义，比如登录，注册页面
    if(wso){
        if(!noRender){
            if(!noRecord){
                recordWso();
            }
            wso.set("href",url);
            $dijit.byId("mainTabContainer").selectChild(wso,true);
        }else{
            if(message == undefined){
                message = "是否确定执行此操作？";
            }
            dojoConfirm(message,null,function(){
                $ajax.get(url,{handleAs : "json"}).then(function(response){
                    handleResponse(response,null,function(){
                        refresh();
                    });
                });
            },null,'W');
        }
    }else{
        redirect(url);
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
    //console.info($env.history);
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
            //console.info($env.history);
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
            // Wait 2 seconds for a response，由于机器性能不同，可能反馈的效率不一，设置10秒以防万一
            timeout: 10000,
            handleAs : "json"
        }).then(function(response){
            clearCurrentStatus(object);
            handleResponse(response,remoteFail,remoteSuccess,remoteNoBack,object);
        },function(e){
            showMessage({type : 'E',content : "请求出现未知出错，请联系管理员！"});
            console.log(e);
        });
    });
    return false;
}

//清楚当前错误（dijitTextBoxError）class的dom并清除状态
function clearCurrentStatus(object){
    var nodes = $(".dijitTextBoxError",object);
    for(var i = 0; i<nodes.length;i++){
        var widgetid = nodes[i]["attributes"]["widgetid"]["value"];
        if(widgetid){
            $dijit.byId(widgetid).set("state","");
        }
    }
    var errorNodes = $('div[id^="error_"]',object);
    for(var y=0;y<errorNodes.length;y++){
        errorNodes[y].innerHTML = "";
    }
}

//处理返回值
function handleResponse(response,remoteFail,remoteSuccess,remoteNoBack,target){
    if(response){
        var errorStatus = false;
        //处理验证信息
        if("validation" in response ){
            errorStatus = true;
            //提示验证消息
            //addFormAlertLine(response["validation"]);
            renderValidError(response["validation"],target);
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

            //根据优先级
            //处理大跳转
            if("location" in response ){
                redirect(response["location"]);
            }else{
                //处理跳转
                if("redirect" in response ){
                    if(response["redirect"]["url"] == "goBack"){
                        goback();
                    }else{
                        goto(response["redirect"]["url"],response["redirect"]['target']);
                    }

                }

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

                if("confirmDialog" in response){
                    var data = response["confirmDialog"];
                    dojoConfirm(data["content"],data["title"],function(){
                        if(data["callback"]){
                            eval(data["callback"]);
                        }
                    },data["cancel"],data["type"])
                }
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
    if("help" in message){
        toaster.remortData = message;
    }

    toaster.show();

}

//显示message help
function showMessageHelp(toaster){
    var data = toaster.remortData;
    if(data && data.help){
        var header = "<strong>消息编号："+data.code+"</strong><br/>";
        data.help = header + "<p>"+ data.help + "</p>";
        dojoConfirm(data.help,data.content,null,null,toaster.messageType);
    }
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

function renderValidError(lines,target){

    for(var i=0;i<lines.length;i++){
        for (var key in lines[i]) {
            var object = dijitObject(key);
            if(object){
                //激活
                //object.focus();
                object.set("state","Error");
                //object.displayMessage(lines[i][key]);
                if(target == undefined){
                    target = currentWso().domNode;
                }
                //object.displayMessage("gogo");
                var nodes = $("div#error_"+fixDijitId(key),target);
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
    if($env){
        //$(".preloader").style("display","none")
        //console.info($dijit.byId('mainTabContainer'));
        $env.mid = mid;
        var wso = currentWso();
        wso.cm = $env.cm;
        console.log("current module line id : "+ $env.cm +" mid : "+ $env.mid + " fid : " + $env.fid );
    }
    //如果性能过差，可以考虑注释
    //refresh_notice_count();
    //console.info(dijitObject('toolbar'));
}

function onModuleShow(mid){
    $env.mid = mid;
}

//用于控件的唯一性标识
function fixDijitId(id){
    var rtId = "";
    if($env){
        //针对登陆和注册页面而言
        if($env.mid == undefined){
            $env.cm = "";
            $env.mid = "";
        }
        if($env.cm == undefined){
            $env.cm = "";
        }
        rtId =  id + "_" + $env.cm + "_" + $env.mid ;
    }
    return rtId;
}

//效果同js原先的confirm
//content ：弹出框内容 ； callback ： 确认后要执行的内容
function dojoConfirm(content,title,callback,cancel,type){
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
                        content =  "<div class='messageContainer text-danger'><i class='icon-remove-sign icon-5x'></i>" +
                        "<div class='messageContent'>" + content + "</div></div>";
                        break;
                    case "W" :
                        content = "<div class='messageContainer text-warning'><i class='icon-question-sign icon-5x'></i>" +
                        "<div class='messageContent'>" +content + "</div></div>";
                        break;
                    default :
                        content =  "<div class='messageContainer text-info'><i class='icon-exclamation-sign icon-5x'></i>" +
                            "<div class='messageContent'>" +content + "</div></div>";
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
                    if(cancel){
                        cancel();
                    }
                    confirmDialog.hide();
                }
            });
            cancelbutton.placeAt(node,"last");

            confirmDialog.containerNode.appendChild(node);
            confirmDialog.show();
        });

}

/*
bug :I need to load "extendedSelect/Row" together with “IndirectSelect” to provide
the select/deselect all function for rows; at the same time, I need to load "select/Row"
to listen to the onSelect event. Unfortunately, when "extendedSelect/Row" & "select/Row"
are loaded together, the onSelect event isn't captured. When only "select/Row" is loaded, it works fine
 */
//包含grid的dialog
function gridDialog(title,structure,dataUrl,valueSegment,selectRowMultiple,target,pagination,pageSize,onSelect,onReturn){
    require(["sckj/DataGrid"],
        function(Grid){
            var hasOnSelect = false;
            if(onSelect){
                hasOnSelect = true;
            }

            var grid = new Grid({
                asyncCache : false,
                pagination : pagination,
                pageSize : pageSize,
                hasOnSelect : hasOnSelect,
                url : dataUrl,
                structure : structure,
                selectRowTriggerOnCell: true,
                selectRowMultiple : selectRowMultiple,
                autoWidth : true,
                autoHeight : false,
                style:"margin-left: 20px;min-width:420px",
                targetDijit : target,
                valueSegment : valueSegment,
                onRowSelect : function(row){
                    if(onSelect){
                        onSelect(row,grid);
                    }
                }
            });
            grid.startup();

            //单选双击获取值
            if(!selectRowMultiple){
                grid.connect(grid, 'onRowDblClick', function(row){
                    if(valueSegment == undefined){
                        valueSegment = 'id';
                    }
                    target.set("value",grid.row(grid.select.row.getSelected()).item()[valueSegment]);
                    closeDialog();
                });
            }

            dojoConfirm(grid,title,function(){

                var ids = grid.select.row.getSelected();
                var value = [];
                //默认值为id
                if(valueSegment == undefined){
                    valueSegment = 'id';
                }
                if(valueSegment){
                    for(var i=0;i<ids.length;i++){
                        //解决null的bug
                        if(grid.row(ids[i]) != null){
                            value.push(grid.row(ids[i]).item()[valueSegment]) ;
                        }

                    }
                }
                value = value.join();
                target.set("value",value);
                if(onReturn){
                    onReturn(value);
                }
            });
        });
}

//值集选择框
function vlGridDialog(valuelist_name,parent_segment_value,all_value,valueSegment,selectRowMultiple,target,pagination,pageSize){
    var structure = [{field : "label",name : "条目",width:"300px"}];
    var params = new Object();
    if(valuelist_name != undefined){
        params.n = valuelist_name;
    }

    if(parent_segment_value != undefined){
        params.pv = parent_segment_value;
    }

    if(all_value != undefined){
        if(all_value){
            params.all = 'true';
        }else{
            params.all = 'false';
        }
    }

    gridDialog("请选择",structure,url("welcome/options",params),valueSegment,selectRowMultiple,target,pagination,pageSize,function(e,grid){
        if(all_value){
            if(e.id == "all"){
                var selected = grid.select.row.getSelected();
                for(var i=0;i<selected.length;i++){
                    if(selected[i] != 'all'){
                        grid.row(selected[i]).deselect();
                        //deSelectById 有bug，弃用
                        //grid.select.row.deSelectById(selected[i]);
                    }
                }
            }else{
                grid.row("all").deselect();
            }
        }
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
    //return $dijit.byId(fixDijitId(id));
    //fix 频繁切换后获取对象失败
    var wso = currentWso();
    if(wso){
        return $dijit.byId(id + "_" + wso.cm + "_" + wso.mid);
    }else{
        return $dijit.byId(id + "_" + $env.cm + "_" + $env.mid);
    }
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
function toolbarAddButton(label,onclick,title){
    require(["dijit/ToolbarSeparator","sckj/form/Button"], function (ToolbarSeparator,Button) {
        onWsoLoad(function() {
            //在工具栏添加一个功能按钮
            var toolBar = dijitObject('toolbar');
            if (toolBar) {
                if (title == undefined) {
                    title = "";
                }
                var bt = new Button({
                    label: label,
                    onClick: function () {
                        if (onclick) {
                            onclick();
                        }
                    },
                    title: title
                });
                bt.startup();
                toolBar.addChild(bt);
            }
        });
    });

}

//在完全加载时运行
function onWsoLoad(fn){
    if(fn){
        var handle = dojo.connect(currentWso(),"onLoad",function(){
                fn();
                dojo.disconnect(handle);
        });
    }
}

//添加链接跳转
function toolBarAddLinkButton(label,url,target,noRender,noRecord){
    toolbarAddButton(label,function(){
        goto(url,target,noRender,noRecord);
    });
}

function in_array(stringToSearch, arrayToSearch) {
    for (var s = 0; s < arrayToSearch.length; s++) {
        var thisEntry = arrayToSearch[s].toString();
        if (thisEntry == stringToSearch) {
            return true;
        }
    }
    return false;
}

//获取选中月的第一天和最后一天
function getFirstAndLastMonthDay( year, month){
    var day = new Date(year,month,0);
    var lastdate = year + '-' + month + '-' + day.getDate();//获取当月最后一天日期
    return lastdate;
}