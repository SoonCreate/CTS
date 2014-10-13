<div class="row paneltitle">
    <h3><?php render_link(array('order','index',array('go'=>'a')),'模块间跳转测试')?></h3>
</div>
<form id="order_create" method="post" action="<?= _url('order','create')?>" onsubmit="return formSubmit(this);">
<div class="container-fluid userd">
    <dl class="row dl-horizontal">
        <dt><label for="severity">*严重性</label></dt>
        <dd>
            <select name="severity" id="severity" data-dojo-type="sckj/form/Select">
                <?= render_options('vl_severity')?>
            </select>
        </dd>
    </dl>
    <dl class="row dl-horizontal">
        <dt><label for="frequency">*发生频率</label></dt>
        <dd>
            <select name="frequency" id="frequency" data-dojo-type="sckj/form/Select">
                <?= render_options('vl_frequency')?>
            </select>
        </dd>
    </dl>
    <?php if(isset($categories)) :?>
    <dl class="row dl-horizontal">
        <dt><label for="category">*分类</label></dt>
        <dd>
            <select name="category" id="category" data-dojo-type="sckj/form/Select">
                <?php foreach($categories as $c):?>
                    <option value="<?= $c?>"><?= get_label('vl_order_category',$c,$order_type)?></option>
                <?php endforeach;?>
            </select>
        </dd>
    </dl>
     <?php endif; ?>
    <dl class="row dl-horizontal">
        <dt><label for="title">*标题</label></dt>
        <dd><input name="title" id="title" type="text" data-dojo-type="sckj/form/TextBox"/></dd>
    </dl>
    <dl class="row dl-horizontal">
        <dt><label for="content">*内容</label></dt>
        <dd>
            <div data-dojo-type="dijit/Editor" id="content_editor"
                 data-dojo-props="plugins:['bold','underline'],focused:true"
                 onChange="synEditorContent(this)"
                 height="150px"></div>
            <input type="hidden" name="content" id='content' data-dojo-type="sckj/form/TextBox"/>
        </dd>
    </dl>
</div>
<div class="row paneltitle">
    <h3>用户基本信息：</h3>
</div>
<div class="container-fluid userd">
    <dl class="row dl-horizontal">
        <dt><label for="contact">*本次投诉联系人</label></dt>
        <dd><input name="contact" id="contact" type="text" data-dojo-type="sckj/form/TextBox"/></dd>
    </dl>
    <dl class="row dl-horizontal">
        <dt><label for="mobile_telephone">*手机号码</label></dt>
        <dd><input name="mobile_telephone" id="mobile_telephone" type="text" data-dojo-type="sckj/form/TextBox"/>填写手机号码，如果“自己”之前有填写过，则自动带出相关信息</dd>
    </dl>
    <dl class="row dl-horizontal">
        <dt><label for="phone_number">公司电话</label></dt>
        <dd><input name="phone_number" id="phone_number" type="text" data-dojo-type="sckj/form/TextBox"/></dd>
    </dl>
    <dl class="row dl-horizontal">
        <dt><label for="full_name">公司名称</label></dt>
        <dd><input name="full_name" id="full_name" type="text" data-dojo-type="sckj/form/TextBox"/></dd>
    </dl>
    <dl class="row dl-horizontal">
        <dt><label for="address">公司地址</label></dt>
        <dd><input name="address" id="address" type="text" data-dojo-type="sckj/form/TextBox"/>
            <input name="order_type" id="order_type" type="hidden" value="<?= $order_type ?>"/>
        </dd>
    </dl>


</div>
<div class="row panelbottom">
    <button type="submit" data-dojo-type="sckj/form/Button" class="success">提交</button>
</form>
</div>

<script type="text/javascript">
    //同步Editor的内容到hidden中
    function synEditorContent(editor){
        require(["dijit/registry"],function(registry){
                var content = registry.byId("content");
                content.set("value",editor.getValue());
         });
    }

</script>