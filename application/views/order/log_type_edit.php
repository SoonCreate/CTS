<h1>订单日志类型修改</h1>
<form id="log_type_create" method="post" action="<?= _url('order','log_type_edit')?>">
    <label for="log_type">*类型名称</label>
    <input name="log_type" id="log_type" type="text" value="<?= _v('log_type')?>"  disabled />
    <br/>

    <label for="description">*描述</label>
    <input name="description" id="description" type="text" value="<?= _v('description')?>"  />
    <br/>

    <label for="field_name">*字段名</label>
    <input name="field_name" id="field_name" type="text" value="<?= _v('field_name')?>" />
    <br/>

    <label for="dll_type">*数据库操作类型</label>
    <select name="dll_type" id="dll_type" value="<?= _v('dll_type')?>">
        <?= render_options('vl_dll_type')?>
    </select>
    <br/>

    <label for="title">*标题格式</label>
    <input name="title" id="title" type="text" value="<?= _v('title')?>" />
    <br/>

    <label for="content">*内容格式</label>
    <textarea id="content" name="content" cols="40" rows="4"><?= _v('content')?></textarea>
    <br/>
    <?php $checked  = 'checked';
        if(!_v('need_reason_flag')){
            $checked = '';
        }
    ?>
    <input type="checkbox" value="1" name="need_reason_flag" id="need_reason_flag" <?= $checked ?>/>
    <label for="need_reason_flag">是否需要填写原因</label>
    <br/>
    <?php  $checked  = 'checked';
    if(!_v('notice_flag')){
        $checked = '';
    }
    ?>
    <input type="checkbox" value="1" name="notice_flag" id="notice_flag" <?= $checked ?>/>
    <label for="notice_flag">是否需要同时创建通知</label>

    <input name="id" id="id" type="hidden" value="<?= _v('id')?>" />
    <button type="submit">提交</button>
</form>

