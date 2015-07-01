<?php
require_once(FCPATH.APPPATH.'functions.php'); 

Helper::beginHtml('Register | Account | Mobile Charity Navigator');

Helper::beginPage( array('id'=>'registerpage', 'data-title'=>'Register', 'data-cn-nologin-btn'=>true, 'data-add-back-btn'=>'true', 'data-back-btn-text'=>'Back' ) );?>
<form action="/account/register" method="post">

	<div data-role="fieldcontain" class="cn-form">

		<fieldset data-role="controlgroup">

			<label class="cn-label" for="signup-name">Name</label>
			<input class="cn-input" type="text" name="name" id="signup-name" value="" />

			<label class="cn-label" for="sign-email">Email</label>
			<input class="cn-input" type="text" name="email" id="sign-email" value="" />

			<label class="cn-label" for="signup-password">Password</label>
			<input class="cn-input"  type="password" name="password" id="signup-password" value="" />
		</fieldset>
	</div>
	<div class="cn-centered">
		<a data-role="button" data-inline="true" href="#" id="registersubmit" data-theme="b">Register!</a>
	</div>
</form><?php
Helper::endPage($navbar);

Helper::endHtml();

