<?php
require_once(FCPATH.APPPATH.'functions.php'); 

Helper::beginHtml($data->name.' | Hot Topics | Mobile Charity Navigator');

Helper::beginPage( array('id'=>$data->slug, 'data-title'=>$data->name, 'data-add-back-btn'=>'true', 'data-back-btn-text'=>'Hot Topics') );?>
<article>
    <h2><?php echo $data->name;?></h2>
    <p><?php echo $data->description;?></p>
    <p><strong>CONTENT...</strong></p>
</article><?php
Helper::endPage($navbar);

Helper::endHtml();

