<?php if (!defined('BASEPATH')) exit('No direct script access allowed');  

//系统报错
$lang['message_must_login'] = "无权访问此页面，请先登陆！";
$lang['message_wrong_url'] = "错误的请求，此页面访问无效！";
$lang['message_no_admin'] = "权限不够，请勿操作其他人数据！";
$lang['message_no_authority'] = "权限不足，请联系系统管理员！";
$lang['message_can_not_do_next'] = "无法完成当前操作，状态流验证错误，可能是没有权限或没有满足条件，请联系管理员！";
$lang['message_register_success'] = "恭喜你，注册成功！请尝试登陆";

//数据操作
$lang['message_data_exists_so_cancel'] = "数据已存在，此次操作被取消！";
$lang['message_data_too_long'] = "字段长度超出要求，请检查！";
$lang['message_data_has_children'] = "数据包含子项，请先清空子项再尝试删除！";
$lang['message_data_repeat'] = "请勿重复保存数据！";
$lang['message_data_useless'] = "提交的数据不可用，请检查！";
$lang['message_save_success'] = "数据保存成功！";
$lang['message_save_failure'] = "数据保存失败！请重试...";
$lang['message_update_success'] = "数据更新成功！";
$lang['message_update_failure'] = "数据更新失败！请重试...";
$lang['message_delete_success'] = "数据删除成功！";
$lang['message_delete_failure'] = "数据删除失败！请重试...";
$lang['message_nothing'] = '你没有创建过任何数据，可以新建第一条！';
$lang['message_login_failure'] = '登陆失败：用户名密码验证失败！';
$lang['message_login_success'] = '欢迎，恭喜登陆成功！';
$lang['message_logout_success'] = '注销成功，如有需要请重新登陆！';
$lang['message_wrong_old_password'] = '原密码输入不正确！';
$lang['message_wrong_re_password'] = '两次密码输入不一致性！';

$lang['message_upload_success'] = "文件上传成功！";
$lang['message_upload_failure'] = "文件上传失败！请重试...";
$lang['message_has_group'] = "图片存在组中，请先失效组！";
$lang['message_wrong_code'] = "验证码输入有误！";

$lang['message_no_content'] = '获取内容失败或内容未创建！';

$lang['message_initpassword_success'] = '密码初始化成功，请尽快修改成你自己的密码！';
$lang['message_initpassword_failure'] = '验证链接已失效，请重新申请！';

//申请店主或街道主任成功提交时
$lang['message_to_owner_success'] = '你的申请已提交，我们讲尽快与你联系，谢谢对本站的支持！';

$lang['message_contain_level'] = "岗位包含职级，请先删除该岗位的职级，再尝试删除！";
$lang['message_contain_employee'] = "对象正在被多名员工使用，请先修改员工数据，再尝试删除！";
$lang['message_can_not_edit_employee'] = "已离职员工信息不允许编辑！";
$lang['message_tax_from_amount_must_be_zero'] = "级数为1时开始金额应为0！";
$lang['message_tax_from_must_be_pre_to'] = "当前级数的开始金额必须是上级的结束金额！";
$lang['message_less_than_initial_year'] = "低于系统配置的初始化年份，无法找到数据！";
$lang['message_no_data'] = "没有查询到任何数据，请检查数据库！";
$lang['message_period_closed'] = "期间状态为关闭，不允许对数据进行修改！";
$lang['message_no_period_date'] = "期间数据未初始化，点击[确认]初始化期间数据！";
$lang['message_error_unknown'] = "未知错误，请联系系统管理员！";
$lang['message_tax_table_not_exists'] = "个税税率表未维护！";
