<?php
require_once(FCPATH.APPPATH.'functions.php'); 

Helper::beginHtml($list->name.' | Top 10 Lists | Mobile Charity Navigator');

Helper::beginPage( array('id'=>$list->slug, 'data-title'=>$list->name, 'data-add-back-btn'=>'false', 'data-back-btn-text'=>'Top 10 Lists', 'data-cn-back-btn'=>'/toptenlists') );
echo "<h2>$list->name</h2>";
echo "<p>$list->description</p>";
if( isset($list->orgs) ){?>
    <lu data-role="listview" data-inset="true"><?php            
        foreach ($list->orgs as $org) {
            echo '<li><a href="/organizations/' .$org->slug. '">' .$org->name.'<span class="ui-li-count" title="' .$org->value_label.'">' .$org->value.'</span></a></li>';
        }?>
    </lu><?php
}
Helper::endPage($navbar);

Helper::endHtml();

