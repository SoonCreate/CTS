<h1>订单日志类型创建</h1>
<form id="log_type_create" method="post" action="<?= _url('order_log_type','create')?>">
    <label for="log_type">*类型名称</label>
    <input name="log_type" id="log_type" type="text" />
    <br/>

    <label for="description">*描述</label>
    <input name="description" id="description" type="text" />
    <br/>

    <label for="field_name">*字段名</label>
    <select id="field_name" name="field_name">
        <?php foreach($fields as $f) :?>
            <option value="<?= $f['COLUMN_NAME']?>"><?= $f['COLUMN_COMMENT'] ?></option>
        <?php endforeach;?>
    </select>
    <br/>

    <label for="field_valuelist_id">字段值集</label>
    <select id="field_valuelist_id" name="field_valuelist_id">
        <option></option>
        <?= render_options('vl_valuelist');?>
    </select>
    <br/>

    <label for="dll_type">*数据库操作类型</label>
    <select name="dll_type" id="dll_type">
        <?= render_options('vl_dll_type')?>
    </select>
    <br/>

    <strong>
        可用的显示字段为：&order_id ; &new_value ; &old_value ; &reason
    </strong>
    <br/>
    <label for="title">*标题格式</label>
    <input name="title" id="title" type="text" />
    <br/>

    <label for="content">*内容格式</label>
    <textarea id="content" name="content" cols="40" rows="4"></textarea>
    <br/>

    <input type="checkbox" value="1" name="need_reason_flag" id="need_reason_flag"/>
    <label for="need_reason_flag">是否需要填写原因(如果初始为空值，则第一次变更不记录原因)</label>
    <br/>

    <input type="checkbox" value="1" name="notice_flag" id="notice_flag" checked/>
    <label for="notice_flag">是否需要同时创建通知</label>
    <button type="submit">提交</button>
</form>

