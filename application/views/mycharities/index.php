<?php
require_once(FCPATH.APPPATH.'functions.php'); 

Helper::beginHtml('My Charities | Mobile Charity Navigator');

Helper::beginPage( array('id'=>'mycharitiespage', 'data-title'=>'My Charities') );?>
<p class="cn-centered">Access your saved charities once you log in to your account.</p>
<ul id="mycharities" data-role="listview" data-inset="true">
</ul><?php 
Helper::endPage($navbar);

Helper::endHtml();

