<label for="segment">*段</label>
<input  id="segment" type="text"
       value="<?php if(_v('default_segment')) : echo _v('default_segment'); else : echo _v('segment') ; endif;?>" disabled /><br/>
<input name="segment"  type="hidden"
       value="<?php if(_v('default_segment')) : echo _v('default_segment'); else : echo _v('segment') ; endif;?>" />

<label for="segment_value">*段值</label>
<input name="segment_value" id="segment_value" type="text"  value="<?= _v('segment_value')?>"/><br/>

<label for="segment_desc">*段描述</label>
<input name="segment_desc" id="segment_desc" type="text" value="<?= _v('segment_desc')?>" /><br/>

<label for="sort">*排序码</label>
<input name="sort" id="sort" type="text" value="<?php if(_v('sort')) : echo _v('sort') ; else : echo 0; endif;?>" /><br/>

<label for="inactive_flag">失效标识</label>
<?php if(_v('inactive_flag') == 1) : ?>
<input name="inactive_flag" id="inactive_flag" type="checkbox" value="1" checked /><br/>
<?php else: ?>
<input name="inactive_flag" id="inactive_flag" type="checkbox" value="1" /><br/>
<?php endif; ?>