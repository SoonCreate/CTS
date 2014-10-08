<form id="feedback" action="<?= _url('order','feedback')?>" method="post">
请您为本次的服务评分：<br/>
<?php foreach($stars as $s){?>
    <label><?= $s['label']?></label>
    <?= $s['value']?><br/>
<?php }?>
    <label for="content">反馈建议：</label>
    <textarea id="content" name="content"></textarea>
    <input type="hidden" name="id" value="<?= v('id')?>"/>
    <button type="submit">提交</button>
</form>
