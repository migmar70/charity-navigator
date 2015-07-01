<?php
require_once(FCPATH.APPPATH.'functions.php'); 

Helper::beginHtml('Countries by Region | Browse | Mobile Charity Navigator');

Helper::beginPage( array('id'=>'countriesbyregion', 'data-title'=>'Countries by Region', 'data-add-back-btn'=>'false', 'data-back-btn-text'=>'Browse', 'data-cn-back-btn'=>'/browse') );
	Helper::countriesControlGroup( $activeButton );
	foreach($items as $item){
		if( count($item->countries) > 0 ){?>
			<div data-role="collapsible" data-content-theme="c">
				<h3><?php echo $item->name;?></h3>
				<p class="cn-centered"><?php echo count($item->countries);?> Countries</p>
				<ul data-role="listview" data-inset="true"><?php
				    foreach($item->countries as $country){
				        echo '<li><a href="/countries/'.$country->slug.'">' .$country->name. '<span class="ui-li-count" title="Organizations">' .$country->orgcount.'</span></a></li>';
				    }?>
				</ul>
			</div><?php
		}
	}
Helper::endPage($navbar);

Helper::endHtml();
