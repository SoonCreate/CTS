/**
 * @fileOverview 核心js工具包
 * @author Sooncreate Studio
 * @version 1.0
 */
//-----------------------------------------------


/**
 * @description 前端工作区的页面跳转函数
 * @since version 1.0
 *
 * @param {string} url  url链接
 * @param {string} target   模块id
 * @param {boolean} noRender   如果为真则不跳转，提示框确认后执行
 * @param {boolean} noRecord   如果为真则不记录返回历史
 * @param {string} message   替换提示框的内容
 */
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

/**
 * @description 跳转到功能选择菜单
 * @since version 1.0
 */
function menu(){
    goto(url('welcome/my_functions?module_id='+$env.mid));
}

/**
 * @description 记录url到返回列表
 * @since version 1.0
 *
 * @param {string} url  url链接
 */
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

/**
 * @description 正则表达式判断是否为url
 * @since version 1.0
 *
 * @param {string} str_url  url链接
 * @return {boolean}
 */
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

/**
 * @description 返回上个历史页面
 * @since version 1.0
 */
function goback(){
    if("history" in $env){
        if($env.history.length > 0 ){
            goto($env.history[0]['url'],$env.history[0]['target'],false,true);
            $env.history.shift();
            //console.info($env.history);
        }
    }
}

/**
 * @description 刷新当前页面
 * @since version 1.0
 *
 * @param {function} then  刷新后执行此function
 */
function refresh(then){
    currentWso().refresh();
    if(then){
        then();
    }
}

/**
 * @description 当前整个页面跳转
 * @since version 1.0
 *
 * @param {string} url  url链接
 */
function redirect(url){
    window.location.href = url;
}

/**
 * @description 判断是否为数组类型
 * @since version 1.0
 *
 * @param {object} obj  判断对象
 * @return {boolean}
 */
function isArray(obj) {
    return Object.prototype.toString.call(obj) === '[object Array]';
}

/**
 * @description 获取当前工作区
 * @since version 1.0
 *
 * @return {object} 工作区
 */
function currentWso(){
    var wso = null;
    var worksapce = $dijit.byId("mainTabContainer");
    if(worksapce){
        wso = worksapce.tablist._currentChild;
    }
    return wso;
}

/**
 * @description form的AJAX提交
 * @since version 1.0
 *
 * @param {object} object  form对象
 * @param {function} beforeSubmit  提交前运行
 * @param {function} remoteFail  服务端返回包含报错信息时运行
 * @param {function} remoteSuccess  服务端返回成功时运行
 * @param {function} remoteNoBack  服务端无返回内容时运行
 * @return {boolean}
 */
function formSubmit(object,beforeSubmit,remoteFail,remoteSuccess,remoteNoBack){
    //钩子 提交前
    if(beforeSubmit){
        beforeSubmit();
    }
    require(["dojo/dom-form","dojo/request"],function(domForm,request){
        clearCurrentStatus(object);
        var data = domForm.toObject(object);
        //提交前验证
        var pass = true;
        var cnt = 0;
        for(var key in data){
            var obj = dijitObject(key);

            if(obj && 'validate' in obj && !obj.validate()){
                _renderSingleError(obj,cnt);
                pass = false;
                cnt = cnt + 1;
            }
        }
        if(pass){
            //fix form中有name为action组件时优先调用组件值的情况 20141017
            request.post(object.attributes["action"]["value"], {
                data: data,
                // Wait 2 seconds for a response，由于机器性能不同，可能反馈的效率不一，设置10秒以防万一
                timeout: 10000,
                handleAs : "json"
            }).then(function(response){
                //clearCurrentStatus(object);
                handleResponse(response,remoteFail,remoteSuccess,remoteNoBack,object);
            },function(e){
                showMessage({type : 'E',content : "请求出现未知出错，请联系管理员！"});
                console.log(e);
            });
        }else{
            return false;
        }

    });
    return false;
}

/**
 * @description 清除当前错误（dijitTextBoxError）class的dom并清除控件状态
 * @since version 1.0
 *
 * @param {object} object  判断对象
 */
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

/**
 * @description 处理服务端的返回
 * @since version 1.0
 *
 * @param {object} response  json对象，服务端返回值
 * @param {function} remoteFail  服务端返回包含报错信息时运行
 * @param {function} remoteSuccess  服务端返回成功时运行
 * @param {function} remoteNoBack  服务端无返回内容时运行
 * @param {object} target  工作区对象，决定作用范围
 */
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

/**
 * @description 分类型显示消息：I|W|E 代表 消息|警告|错误 ，显示效果也不同
 * @since version 1.0
 *
 * @param {object} message  消息对象
 */
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

/**
 * @description 结合系统消息配置，可获取当前报错的帮助手册
 * @since version 1.0
 *
 * @param {object} toaster  消息发布控件
 */
function showMessageHelp(toaster){
    var data = toaster.remortData;
    if(data && data.help){
        var header = "<strong>消息编号："+data.code+"</strong><br/>";
        data.help = header + "<p>"+ data.help + "</p>";
        dojoConfirm(data.help,data.content,null,null,toaster.messageType);
    }
}

/**
 * @description 备用。主要用于在表单抬头提示验证信息
 * @since version 1.0
 *
 * @param {object} lines  json对象，服务端返回的消息
 */
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

/**
 * @description 备用，获取当前form抬头的报错区域
 * @since version 1.0
 *
 * @return {object}
 */
function currentAlertPane(){
    return  $dom.byId($env.cm+"_formalert");
}

/**
 * @description 备用，关闭当前form抬头的报错区域
 * @since version 1.0
 */
function formAlertclose(){
    require(["dojo/dom-style"],
        function(domStyle){
            var o = currentAlertPane();
            clearFormAlertLine();
            domStyle.set(o,"display","none");
        });
}

/**
 * @description 备用，清除当前form抬头的报错信息
 * @since version 1.0
 */
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

/**
 * @description 渲染表单验证的报错提示，位于控件底部
 * @since version 1.0
 *
 * @param {object} lines  服务端返回验证消息
 * @param {object} target  作用于工作区对象
 */
function renderValidError(lines,target){

    for(var i=0;i<lines.length;i++){
        for (var key in lines[i]) {
            var object = dijitObject(key);
            if(object){
                _renderSingleError(object,i,lines[i][key],target);
            }
        }

    }

}

/**
 * @description 渲染单个控件对象的验证报错提示
 * @since version 1.0
 *
 * @param {object} object  表单控件对象
 * @param {int} index  位于form中的位置
 * @param {string} invalidMessage  自定义报错信息
 * @param {object} target  作用于工作区对象
 */
function _renderSingleError(object,index,invalidMessage,target){
    if(object){
        //第一个报错控件激活
        if(index == 0){
            object.focus();
            //判断函数存在与否
            //if("displayMessage" in object && "getErrorMessage" in object){
            //    object.displayMessage(object.getErrorMessage());
            //}
        }
        //else{
        //    object.displayMessage();
        //}
        object.set("state","Error");

        if(target == undefined){
            target = currentWso().domNode;
        }
        //console.info(target);
        //console.info("div#error_"+object.id);
        var nodes = $("div#error_"+object.id,target);
        //console.info(nodes);
        for(var y=0;y<nodes.length;y++){
            if(invalidMessage){
                nodes[y].innerHTML = invalidMessage;
            }else{
                //先检验是否必输
                if("_missingMsg" in object){
                    //摘自源码
                    var isValid = object.disabled || object.isValid();
                    nodes[y].innerHTML = isValid ? "" : object._missingMsg;
                }
                if("getErrorMessage" in object){
                    nodes[y].innerHTML = object.getErrorMessage();
                }
            }

        }
    }
}

/**
 * @description 生成控件唯一性标识id
 * @since version 1.0
 *
 * @param {string} id  控件原始id
 * @return {string} 生成后id
 */
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

/**
 * @description 替代js原生的confirm方法
 * @since version 1.0
 *
 * @param {string} content  提示内容
 * @param {string} title  提示标题
 * @param {function} callback  点击[确认]后运行
 * @param {function} cancel  点击[取消]后运行
 * @param {string} type  I|W|E 代表 消息|警告|错误
 */
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

/**
 * @description 表格格式的弹出框
 * bug :I need to load "extendedSelect/Row" together with “IndirectSelect” to provide
 * the select/deselect all function for rows; at the same time, I need to load "select/Row"
 * to listen to the onSelect event. Unfortunately, when "extendedSelect/Row" & "select/Row"
 * are loaded together, the onSelect event isn't captured. When only "select/Row" is loaded, it works fine
 * @since version 1.0
 *
 * @param {string} title  弹出框标题
 * @param {object} structure  json对象，grid的结构
 * @param {string} dataUrl  数据来源url
 * @param {string} valueSegment  值字段，选择行时返回该字段的值
 * @param {boolean} selectRowMultiple  是否多行选择
 * @param {object} target  目标控件对象，返回值到该控件
 * @param {boolean} pagination  是否分页
 * @param {int} pageSize  单页条目数
 * @param {function} onSelect  行被选择时运行
 * @param {function} onReturn  目标控件被赋值后运行
 */
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

/**
 * @description 值列表选择提示框
 * @since version 1.0
 *
 * @param {string} valuelist_name  值集名称
 * @param {string} parent_segment_value  父值集项目名称
 * @param {Boolean} all_value  是否包含"所有值"选择
 * @param {string} valueSegment  值字段，选择行时返回该字段的值
 * @param {boolean} selectRowMultiple  是否多行选择
 * @param {object} target  目标控件对象，返回值到该控件
 * @param {boolean} pagination  是否分页
 * @param {int} pageSize  单页条目数
 */
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

/**
 * @description 关闭提示框
 * @since version 1.0
 */
function closeDialog(){
    var di = $dijit.byId("confirmDialog");
    if(di){
        di.hide();
    }
}

/**
 * @description 关闭提示框并刷新当前工作区
 * @since version 1.0
 */
function closeDialogAndRefresh(){
    closeDialog();
    refresh();
}

/**
 * @description 返回唯一标识处理后的控件对象
 * @since version 1.0
 *
 * @param {string} id  控件id
 * @return {object} 控件对象
 */
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

/**
 * @description 刷新未读消息数量:后续等待优化，采用ajax长轮询
 * @since version 1.0
 *
 * @param {int} n 未读消息数量
 */
function refresh_notice_count(n){
    if(n){
        $dom.byId("scbadge").innerHTML = n;
    }else{
        $ajax.get(url('welcome/notice_need_to_read'),{handleAs : "text"}).then(function(data){
            $dom.byId("scbadge").innerHTML = data;
        });
    }

}

/**
 * @description 往工具栏加入功能按钮
 * @since version 1.0
 *
 * @param {string} label  按钮标签
 * @param {function} onclick  点击事件
 * @param {string} title  鼠标漂浮按钮上时的提示内容
 */
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

function uploadFileDialog(toUrl,params){
    require(["dojox/layout/ContentPane","dojo/io/iframe"],function(ContentPane,iframe){
        var cp = new ContentPane({
            href : url(toUrl,params),
            id : "uploadFileContentPane"
        });
        cp.startup();
        dojoConfirm(cp,"文件上传",function(){
            iframe.send({
                form: "upload_file",
                method: "POST",
                timeOut: 2000,
                handleAs: "json",
                url : url(toUrl)
            }).then(function(response) {
                //成功
                handleResponse(response,null,function(){
                    refresh();
                })
            },function (error) {
                //失败
                console.info(error);
            });
        });
    });
}

function showLoading(){
    require(["dojo/dom","dojo/dom-style"],function(dom,domStyle){
        var p = dom.byId("preloader");
        domStyle.set(p, "opacity", "1");
        domStyle.set(p,"display","block");
    });
}

function hideLoading(){
    require(["dojo/dom","dojo/dom-style","dojo/_base/fx"],function(dom,domStyle,baseFx){
        if(dom.byId("preloader")){
            baseFx.fadeOut({  //Get rid of the loader once parsing is done
                node: "preloader",
                //,
                onEnd: function() {
                    domStyle.set("preloader","display","none");
                }
            }).play();
        }
    });
}