<?php
require_once(FCPATH.APPPATH.'functions.php'); 

Helper::beginHtml('Categories | Browse | Mobile Charity Navigator');

Helper::beginPage( array('id'=>'categories', 'data-title'=>'Categories', 'data-add-back-btn'=>'false', 'data-back-btn-text'=>'Browse', 'data-cn-back-btn'=>'/browse') );?>
<p class="cn-centered"><?php echo count($items);?> Categories</p>
<ul data-role="listview" data-inset="true"><?php
    foreach($items as $item){
        echo '<li><a href="/categories/'.$item->slug.'">' .$item->name. '<span class="ui-li-count" title="Organizations">' .$item->orgcount.'</span></a></li>';
    }?>
</ul><?php
Helper::endPage($navbar);

Helper::endHtml();
