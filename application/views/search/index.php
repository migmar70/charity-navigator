<?php
require_once(FCPATH.APPPATH.'functions.php'); 

Helper::beginHtml('Search | Mobile Charity Navigator');

Helper::beginPage( array('id'=>'searchpage', 'data-title'=>'Search') );?>
<input type="search" name="search" id="search" value="" placeholder="Search for charities" />
<ul id="search-results" data-role="listview" data-inset="true" data-autodividers="true">
</ul><?php 
Helper::endPage($navbar);

Helper::endHtml();

