<?php
require_once(FCPATH.APPPATH.'functions.php'); 

Helper::beginHtml('Tips for Donors | Mobile Charity Navigator');

Helper::beginPage( array('id'=>'tips', 'data-title'=>'Tips for Donors', 'data-add-back-btn'=>'false', 'data-back-btn-text'=>'Featured', 'data-cn-back-btn'=>'/featured') );
foreach($items as $item){?>
	<div data-role="collapsible" data-content-theme="c">
		<h3><?php echo $item->name;?></h3>
		<p><?php echo $item->description;?></p>
	</div><?php
}
Helper::endPage($navbar);

Helper::endHtml();
