define(["dojo/_base/declare","dojox/layout/ContentPane","dojo/_base/fx","dojo/dom-style","dojo/dom"],
    function(declare,ContentPane,baseFx,domStyle,dom){
        return declare("",[ContentPane],{
            //模块id
            mid : "",
            //模块下的程序ID
            cm : "",
            //去除加载提示
            loadingMessage : '<i class="icon-spinner icon-spin"></i>',

            cancel : function(){
                this.perRefresh();
                this.inherited(arguments);
            },

            //刷新前效果
            perRefresh : function(){
                domStyle.set(this.domNode, "opacity", "1");
                showLoading();
                //baseFx.fadeOut({node: this.domNode ,duration:100}).play();
            },

            onLoad : function(){
                this.inherited(arguments);
                this.refresh_env();
            },

            onShow : function(){
                this.inherited(arguments);
                $env.mid = this.mid;
            },

            //没有定义好环境，则刷新
            refresh_env : function(){
                var wso = this;
                //预加载，加载后动画
                hideLoading();

                domStyle.set(this.domNode, "opacity", "0");
                //动画加载
                baseFx.fadeIn({node: this.domNode,duration:100 }).play();
                if($env){
                    //$(".preloader").style("display","none")
                    //console.info($dijit.byId('mainTabContainer'));
                    $env.mid = wso.mid;
                    wso.cm = $env.cm;
                    console.log("current module line id : "+ $env.cm +" mid : "+ $env.mid + " fid : " + $env.fid );
                }

                //每次刷新更新状态
                this._refreshBackButton();

                //如果性能过差，可以考虑注释
                //refresh_notice_count();
                //console.info(dijitObject('toolbar'));
            },
            //更新返回按钮状态，如果无返回则无法点击
            _refreshBackButton : function(){
                var backButton = dijitObject('wsoGoBack');
                if($env.history == undefined || $env.history.length == 0){
                    backButton.set("disabled",true);
                }else{
                    backButton.set("disabled",false);
                }
            }
        });
    });