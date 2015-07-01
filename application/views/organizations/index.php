<?php
require_once(FCPATH.APPPATH.'functions.php'); 

Helper::beginHtml($data->name.' | Charity | Mobile Charity Navigator');

Helper::beginPage( array('id'=>$data->slug, 'data-title'=>$data->name, 'data-add-back-btn'=>'true') );?>

<a id="addtomycharitieslink" href="#">Add to my charities.</a>

<article>
    <h2><?php echo $data->name;?></h2>
    <p><?php echo $data->mission;?></p>
</article>
<strong>CONTENT...</strong><?php
Helper::endPage($navbar);

Helper::endHtml();

