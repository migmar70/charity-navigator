<?php
require_once(FCPATH.APPPATH.'functions.php'); 

Helper::beginHtml('Celebrities | Browse | Mobile Charity Navigator');

Helper::beginPage( array('id'=>'celebrities', 'data-title'=>'Celebrities', 'data-add-back-btn'=>'false', 'data-back-btn-text'=>'Browse', 'data-cn-back-btn'=>'/browse') );
	Helper::celebritiesControlGroup( $activeButton );?>
	<p class="cn-centered"><?php echo count($items);?> Celebrities</p>
	<ul data-role="listview" data-inset="true"><?php
	    foreach($items as $item){
	        echo '<li><a href="/celebrities/'.$item->slug.'">' .$item->name. '<span class="ui-li-count" title="Organizations">' .$item->orgcount.'</span></a></li>';
	    }?>
	</ul><?php
Helper::endPage($navbar);

Helper::endHtml();
