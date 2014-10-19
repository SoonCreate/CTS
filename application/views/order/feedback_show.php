请您为本次的服务评分：<br/>
<?php foreach($stars as $s){?>
    <label><?= $s['feedback_desc']?></label>
    <?= $s['stars']?><br/>
<?php }?>
<label for="content">反馈建议：</label>
<p><?= $content ?></p>
