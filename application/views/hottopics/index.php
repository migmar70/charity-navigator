<?php
require_once(FCPATH.APPPATH.'functions.php'); 

Helper::beginHtml('Hot Topics | Mobile Charity Navigator');

Helper::beginPage( array('id'=>'hot-topics', 'data-title'=>'Hot Topics', 'data-add-back-btn'=>'true', 'data-back-btn-text'=>'Featured') );?>
<ul data-role="listview" data-inset="true"><?php
    foreach($items as $item){
        echo '<li><a href="/hottopics/'.$item->slug.'">' .$item->name. '</a></li>';
    }?>
</ul><?php
Helper::endPage($navbar);

Helper::endHtml();
