<?php
require_once(FCPATH.APPPATH.'functions.php'); 

Helper::beginHtml('Mobile Charity Navigator');

Helper::beginPage( array('id'=>'featured', 'data-title'=>'Featured') );?>
<ul data-role="listview" data-inset="true">
    <li><a href="/toptenlists">Top 10 Lists</a></li>
    <li><a href="/hottopics">Hot Topics</a></li>
    <li><a href="/tips">Tips for Donors</a></li>
    <li><a href="/methodology">Methodology</a></li>
    <li><a href="/donate">Donate to Charity Navigator</a></li>
</ul><?php 
Helper::endPage($navbar);

Helper::endHtml();

