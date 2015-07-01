<?php
require_once(FCPATH.APPPATH.'functions.php'); 

Helper::beginHtml($data->name.' | Countries | Browse | Mobile Charity Navigator');

Helper::beginPage( array('id'=>$data->slug, 'data-title'=>$data->name, 'data-add-back-btn'=>'false', 'data-back-btn-text'=>'Countries', 'data-cn-back-btn'=>'/countries') );
echo "<h2>$data->name</h2>";
echo '<p class="cn-centered">'.count($data->orgs).' organizations.</p>';
if( isset($data->orgs) ){?>
    <ul data-role="listview" data-inset="true"><?php            
        foreach ($data->orgs as $org) {
            echo '<li><a href="/organizations/' .$org->slug. '">' .$org->name.'</a></li>';
        }?>
    </ul><?php
}
Helper::endPage($navbar);

Helper::endHtml();

