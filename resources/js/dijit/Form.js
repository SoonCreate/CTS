define(["dojo/_base/declare", "dijit/form/Form", "dojo/request","dijit/registry","dojo/dom-form"],
    function(declare,Form,request,registry,domForm){
        /*
         *   摘要:
         *       表单组件
         */
        return declare("",[Form],{

            //预留的函数：失败后，成功后，无返回后
            failureFunction : function(){},
            successFunction : function(){},
            noBackFunction : function(){},
            remoteHandleAs : "json",
            errorStatus : false,

            reset : function(){
                this.inherited(arguments);
            },

            //展示错误漂浮提示
            _renderError : function(id,errorMessage){
                var object = registry.byId(id);
                object.focus();
                object.set("state","Error");
                object.displayMessage(errorMessage);
            },

            onSubmit : function(){
                alert("1111");
                //this.runAjaxSubmit();
                return false;
            },
            //处理返回结果
            handleResponse : function(response){
                //处理验证信息
                if("validation" in response ){
                    this.errorStatus = true;
                }

                //处理消息
                if("message" in response ){

                }

                //处理数据
                if("data" in response ){

                }

                //处理跳转
                if("redirect" in response ){
                    goto(response["redirect"]);
                }
            },

            runAjaxSubmit : function () {
                //获取消息栏
                //var toaster = registry.byId("toaster");
                //toaster.setContent('Twinkies are now being served in the vending machine!', 'fatal',5000);
                //toaster.show();

                //阻止提交事件
                //evt.stopPropagation();
                //evt.preventDefault();
                //验证
                if(this.validate()){
                    // Post the data to the server
                    request.post(this.action, {
                        // Send the username and password
                        data: domForm.toObject(this.domNode),
                        // Wait 2 seconds for a response
                        timeout: 2000,
                        handleAs : this.remoteHandleAs
                    }).then(function(response){
                        this.handleResponse(response);
                    },function(){
                        console.log('remote request error!');
                    });

                }
            }

        });
    });