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
                return false;
            },
            //处理返回结果
            handleResponse : function(response){
                console.log(response);
            }

        });
    });