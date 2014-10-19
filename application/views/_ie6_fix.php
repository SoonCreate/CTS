<!--IE6/7版本提示开始-->
<style type="text/css">
    #ie6-warning{background:#FF0; position:absolute;top:0; left:0;font-size:12px; line-height:24px; color:#F00;
        padding:0 10px;}
    #ie6-warning img{float:right; cursor:pointer; margin-top:4px;}
    #ie6-warning a{text-decoration:none;}
</style>


<!--[if lte IE 7]>
<link rel="stylesheet" href="//115.29.6.162/cdn/dojo/gridx/resources/claro/Gridx.css" />
<link rel="stylesheet" type="text/css" href="//115.29.6.162/cdn/dojo/dojox/grid/enhanced/resources/claro/EnhancedGrid.css" />
<div id="ie6-warning">
    <img src="resources/images/ie6close.gif" width="14" height="14" onclick="closeme();" alt="关闭提示" />
    您正在使用 Internet Explorer 低版本的IE浏览器。为更好的浏览本页，建议您将浏览器升级到
    <a href="http://www.microsoft.com/china/windows/internet-explorer/ie8howto.aspx" target="_blank">IE8</a>
    或以下浏览器：<a href="http://www.firefox.com.cn/download/">Firefox</a> / <a href="http://www.google.cn/chrome">
    Chrome</a> / <a href="http://www.apple.com.cn/safari/">Safari</a> / <a href="http://www.Opera.com/">Opera</a>
</div>
<script type="text/javascript">
    function closeme()
    {
        var div = document.getElementById("ie6-warning");
        div.style.display ="none";
    }
    function position_fixed(el, eltop, elleft){
// check if this is IE6
        if(!window.XMLHttpRequest)
            window.onscroll = function(){
                el.style.top = (document.documentElement.scrollTop + eltop)+"px";
                el.style.left = (document.documentElement.scrollLeft + elleft)+"px";
            }
        else el.style.position = "fixed";
    }
    position_fixed(document.getElementById("ie6-warning"),0, 0);
</script>
<![endif]-->
<!--版本提示结束-->