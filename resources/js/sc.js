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