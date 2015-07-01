<?php
require_once(FCPATH.APPPATH.'functions.php'); 

Helper::beginHtml($data->name.' | Categories | Browse | Mobile Charity Navigator');

Helper::beginPage( array('id'=>$data->slug, 'data-title'=>$data->name, 'data-add-back-btn'=>'false', 'data-back-btn-text'=>'Categories', 'data-cn-back-btn'=>'/categories') );
echo "<h2>$data->name</h2>";
if( isset($data->orgs) ){?>
	<p class="cn-centered"><?php echo count($data->orgs);?> Organizations</p>
    <ul data-role="listview" data-inset="true"><?php            
        foreach ($data->orgs as $org) {
            echo '<li><a href="/organizations/' .$org->slug. '">' .$org->name.'</a></li>';
        }?>
    </ul><?php
}
Helper::endPage($navbar);

Helper::endHtml();

