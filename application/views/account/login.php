<?php
require_once(FCPATH.APPPATH.'functions.php'); 

Helper::beginHtml('Log in | Account | Mobile Charity Navigator');

Helper::beginPage( array('id'=>'loginpage', 'data-title'=>'Log in', 'data-cn-nologin-btn'=>true, 'data-add-back-btn'=>'true', 'data-back-btn-text'=>'Back' ) );?>

<a id="registerlink" href="#">Register for a free account.</a>

<form id="loginform" action="/account/authenticate" method="post">
	<div data-role="fieldcontain" class="cn-form">
		<fieldset data-role="controlgroup">
			<label class="cn-label" for="login-email">Email</label>
			<input class="cn-input" type="text" name="email" id="login-email" value="" />

			<label class="cn-label" for="login-password" >Password</label>
			<input class="cn-input"  type="password" name="password" id="login-password" value="" />
		</fieldset>
	</div>
	<div class="cn-centered">
		<a data-role="button" data-inline="true" href="#" id="loginsubmit" data-theme="b">Log in</a>
	</div>
</form><?php
Helper::endPage($navbar);

Helper::endHtml();

