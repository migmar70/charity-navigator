<?php
require_once(FCPATH.APPPATH.'functions.php'); 

Helper::beginHtml('Top 10 Lists | Mobile Charity Navigator');

Helper::beginPage( array('id'=>'top-10-lists', 'data-title'=>'Top 10 Lists', 'data-add-back-btn'=>'false', 'data-back-btn-text'=>'Featured', 'data-cn-back-btn'=>'/featured') );?>
<ul data-role="listview" data-inset="true"><?php
    foreach($items as $item){
        echo '<li><a href="/toptenlists/' .$item->slug. '">' .$item->name. '<span class="ui-li-count" title="Organizations">' .$item->orgcount.'</span></a></li>';
    }?>
</ul><?php
Helper::endPage($navbar);

Helper::endHtml();

