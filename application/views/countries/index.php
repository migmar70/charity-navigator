<?php
require_once(FCPATH.APPPATH.'functions.php'); 

Helper::beginHtml('Countries | Browse | Mobile Charity Navigator');

Helper::beginPage( array('id'=>'countries', 'data-title'=>'Countries', 'data-add-back-btn'=>'false', 'data-back-btn-text'=>'Browse', 'data-cn-back-btn'=>'/browse') );
	Helper::countriesControlGroup( $activeButton );
	echo '<p class="cn-centered">'.count($items).' countries.</p>';?>
	<ul data-role="listview" data-inset="true"><?php
	    foreach($items as $item){
	        echo '<li><a href="/countries/'.$item->slug.'">' .$item->name. '<span class="ui-li-count" title="Organizations">' .$item->orgcount.'</span></a></li>';
	    }?>
	</ul><?php
Helper::endPage($navbar);

Helper::endHtml();
