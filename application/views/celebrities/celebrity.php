<?php
require_once(FCPATH.APPPATH.'functions.php'); 

Helper::beginHtml($data->name.' | Celebrity | Browse | Mobile Charity Navigator');

Helper::beginPage( array('id'=>$data->slug, 'data-title'=>$data->name, 'data-add-back-btn'=>'false', 'data-back-btn-text'=>'Celebrities', 'data-cn-back-btn'=>'/celebrities') );
echo "<h2>$data->name</h2>";
if( isset($data->orgs) ){?>
    <ul data-role="listview" data-inset="true"><?php            
        foreach ($data->orgs as $org) {
            echo '<li><a href="/organizations/' .$org->slug. '">' .$org->name.'<span class="ui-li-count" title="Relationship">' .$org->relationship.'</span></a></li>';
        }?>
    </ul><?php
}
Helper::endPage($navbar);

Helper::endHtml();

