<?php
require_once(FCPATH.APPPATH.'functions.php'); 

Helper::beginHtml('Celebrities by Relationship | Browse | Mobile Charity Navigator');

Helper::beginPage( array('id'=>'celebritiesbyrelationship', 'data-title'=>'Celebrities by Relationship', 'data-add-back-btn'=>'false', 'data-back-btn-text'=>'Browse', 'data-cn-back-btn'=>'/browse') );
	Helper::celebritiesControlGroup( $activeButton );
	foreach($items as $item){
		if( count($item->celebrities) > 0 ){?>
			<div data-role="collapsible" data-content-theme="c">
				<h3><?php echo $item->name;?></h3>
				<p class="cn-centered"><?php echo count($item->celebrities);?> Celebrities</p>
				<ul data-role="listview" data-inset="true"><?php
				    foreach($item->celebrities as $celebrity){
				        echo '<li><a href="/celebrities/'.$celebrity->slug.'">' .$celebrity->name. '<span class="ui-li-count" title="Organizations">' .$celebrity->orgcount.'</span></a></li>';
				    }?>
				</ul>
			</div><?php
		}
	}
Helper::endPage($navbar);

Helper::endHtml();
