<?php
require_once(FCPATH.APPPATH.'functions.php'); 

Helper::beginHtml('Browse | Mobile Charity Navigator');

Helper::beginPage( array('id'=>'browse', 'data-title'=>'Browse') );?>
<ul data-role="listview" data-inset="true">
    <li><a href="/categories">By Category</a></li>
    <li><a href="/causes">By Cause</a></li>
    <li><a href="/celebrities">By Celebrity</a></li>
    <li><a href="/countries">By Country</a></li>
</ul><?php 
Helper::endPage($navbar);

Helper::endHtml();

