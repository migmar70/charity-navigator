<?php
require_once(FCPATH.APPPATH.'functions.php'); 

Helper::beginHtml('Methodology | Mobile Charity Navigator');

Helper::beginPage( array('id'=>'methodology', 'data-title'=>'Methodology', 'data-add-back-btn'=>'true', 'data-back-btn-text'=>'Featured') );?>
<p>
Charity Navigator works to guide intelligent giving. Our goal is to help people give to charity with confidence. At the same time, we aim to help charities by shining lights on truly effective organizations. In doing so, we believe we can help ensure that charitable giving keeps pace with the growing need for charitable programs.
</p>
<p>
Our approach to rating charities is driven by those two objectives: helping givers and celebrating the work of charities. The pages listed below describe how we select charities to evaluate, how we classify and rate them, and what givers can conclude based on our ratings.
</p>
<ul data-role="listview" data-inset="true"><?php
    foreach($items as $item){
        echo '<li><a href="/methodology/'.$item->slug.'">' .$item->name. '</a></li>';
    }?>
</ul><?php
Helper::endPage($navbar);

Helper::endHtml();
