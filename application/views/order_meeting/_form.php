<label for="title">*会议主题</label>
<input name="title" id="title" type="text" value="<?= _v('title')?>"/>
<br/>

<label for="start_date">*开始时间</label>
<input name="start_date" id="start_date" type="text" value="<?= _v('start_date')?>"  />
<br/>

<label for="end_date">*结束时间</label>
<input name="end_date" id="end_date" type="text" value="<?= _v('end_date')?>" />
<br/>


<label for="site">*会议地点</label>
<input name="site" id="site" type="text" value="<?= _v('site')?>" />
<br/>

<label for="anchor">*主持人</label>
<input name="anchor" id="anchor" type="text" value="<?= _v('anchor')?>"/>
<br/>

<label for="recorder">记录人</label>
<input name="recorder" id="recorder" type="text" value="<?= _v('recorder')?>" />
<br/>

<label for="actor">*参与者</label>
<textarea id="actor" name="actor" cols="40" rows="4"><?= _v('actor')?></textarea>
<br/>

<label for="discuss">会议决议</label>
<textarea id="discuss" name="discuss" cols="100" rows="10"><?= _v('discuss')?></textarea>
<br/>

<label for="order_id">*处理投诉单</label>
<input name="order_id" id="order_id" type="text" value="<?= _v('order_id')?>" />
以英文“,”分隔可关联多个投诉单
<br/>