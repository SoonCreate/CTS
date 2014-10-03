<a href="<?= _url('user','index')?>">用户管理</a>
<a href="<?= _url('role','index')?>">角色管理</a>
<a href="<?= _url('modules','index')?>">模块管理</a>
<a href="<?= _url('functions','index')?>">功能管理</a>
<a href="<?= _url('auth_object','index')?>">权限对象管理</a>
<a href="<?= _url('order_log_type','index')?>">订单日志类型管理</a>
<a href="<?= _url('order','index')?>">投诉订单列表</a>
<a href="<?= _url('order','choose_create')?>">创建新投诉</a>
<a href="<?= _url('order_meeting','create')?>">召开会议</a>
<br/>
<br/>
<br/>

<form method="get" action="<?= _url('order','show');?>">
    <label for="id">直接输入订单号：</label>
    <input name="id" id="id" /><button type="submit">查找</button>
</form>
<h1>我的模块</h1>
<?php if(isset($modules)):?>
    <ul>
        <?php  foreach($modules as $m) :?>
            <li><a href="<?= _url('welcome','my_functions',array('module_id'=>$m['module_id']))?>"><?= $m['module_desc']?></a></li>
        <?php  endforeach;?>
    </ul>
<?php endif;?>