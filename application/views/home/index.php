<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once(dirname(__FILE__).'/helper.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Charity Navigator Mobile</title>

    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />

    <link rel="stylesheet" href="/assets/css/style.css" />

    <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
    <!--script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script-->
    <script src="/assets/js/jquery.mobile-1.2.0.js"></script>
</head>
<body class="<?php echo $authenticatedCls;?>"><?php
	Helper::beginPage( array('id'=>'home', 'data-title'=>'Home') );?>

	<input type="search" name="search" id="search" placeholder="Search for charities" />
	<ul id="search-results" data-role="listview" data-inset="true" data-autodividers="true">
	</ul>
	<ul data-role="listview" data-inset="true">
	    <li><a href="#toptenlists">Top 10 Lists</a></li>
	    <li><a href="#hottopics">Hot Topics</a></li>
	    <li><a href="#tips">Choosing a Charity</a></li>
	    <li><a href="#donate">Donate to Charity Navigator</a></li>
	</ul><?php 
	Helper::endPage('home');

	Helper::beginPage( array('id'=>'loginpage', 'data-title'=>'Log in', 'data-cn-nologin-btn'=>true, 'data-add-back-btn'=>'true', 'data-back-btn-text'=>'Back' ) );?>

	<a id="registerlink" href="#registerpage">Register for a free account.</a>

	<form action="/api2/authenticate" method="post">
		<div data-role="fieldcontain" class="cn-form">
			<fieldset data-role="controlgroup">

				<label class="cn-label" for="loginemail">Email</label>
				<input class="cn-input" type="text" name="loginemail" id="loginemail" value="" />

				<label class="cn-label" for="loginpassword" >Password</label>
				<input class="cn-input"  type="password" name="loginpassword" id="loginpassword" value="" />

			</fieldset>
		</div>
		<a data-role="button" data-inline="true" href="#" id="loginsubmit">Log in</a>
	</form><?php
	Helper::endPage('');

	Helper::beginPage( array('id'=>'registerpage', 'data-title'=>'Register', 'data-cn-nologin-btn'=>true, 'data-add-back-btn'=>'true', 'data-back-btn-text'=>'Back' ) );?>
	<form id="registrationform" action="/api2/register" method="post">
		<div data-role="fieldcontain" class="cn-form">
			<fieldset data-role="controlgroup">

				<label class="cn-label" for="registername">Name</label>
				<input class="cn-input" type="text" name="registername" id="registername" value="" maxlength="64" />

				<label class="cn-label" for="registeremail">Email</label>
				<input class="cn-input" type="text" name="registeremail" id="registeremail" value=""  maxlength="64" />

				<label class="cn-label" for="registerpassword">Password</label>
				<input class="cn-input"  type="password" name="registerpassword" id="registerpassword" value=""  maxlength="64" />

			</fieldset>
		</div>
		<a data-role="button" data-inline="true" href="#" id="registersubmit">Register!</a>
	</form><?php
	Helper::endPage('');


	Helper::beginPage( array('id'=>'toptenlists', 'data-title'=>'Top 10 Lists', 'data-add-back-btn'=>'true', 'data-back-btn-text'=>'Home') );?>
	<ul data-role="listview" data-inset="true"><?php
	    foreach($toptenlists as $item){
	        echo '<li><a href="#toptenlist/' .$item->slug. '">' .$item->name. '<span class="ui-li-count" title="Organizations">' .$item->orgcount.'</span></a></li>';
	    }?>
	</ul><?php
	Helper::endPage('home');
	
	Helper::beginPage( array('id'=>'toptenlist', 'data-title'=>'Top 10 List', 'data-add-back-btn'=>'true', 'data-back-btn-text'=>'Top 10 Lists') );
	Helper::endPage('home');


	Helper::beginPage( array('id'=>'organization', 'data-title'=>'Organization', 'data-add-back-btn'=>'true', 'data-back-btn-text'=>'Back') );
	Helper::endPage('home');


	Helper::beginPage( array('id'=>'hottopics', 'data-title'=>'Hot Topics', 'data-add-back-btn'=>'true', 'data-back-btn-text'=>'Home') );?>
	<ul data-role="listview" data-inset="true"><?php
	    foreach($hottopics as $hottopic){
	        echo '<li><a href="#hottopic/' .$hottopic->slug. '">' .$hottopic->name. '</a></li>';
	    }?>
	</ul><?php
	Helper::endPage('home');

	Helper::beginPage( array('id'=>'hottopic', 'data-title'=>'Hot Topic', 'data-add-back-btn'=>'true', 'data-back-btn-text'=>'Hot Topics') );
	Helper::endPage('home');


	Helper::beginPage( array('id'=>'tips', 'data-title'=>'Choosing a Charity', 'data-add-back-btn'=>'true', 'data-back-btn-text'=>'Home') );?>
	<ul data-role="listview" data-inset="true"><?php
	    foreach($tips as $tip){
	        echo '<li><a href="#tip/' .$tip->slug. '">' .$tip->name. '</a></li>';
	    }?>
	</ul><?php
	Helper::endPage('home');

	Helper::beginPage( array('id'=>'tip', 'data-title'=>'Tip', 'data-add-back-btn'=>'true', 'data-back-btn-text'=>'Choosing a Charity') );
	Helper::endPage('home');

	Helper::beginPage( array('id'=>'donate', 'data-title'=>'Donate', 'data-add-back-btn'=>'true', 'data-back-btn-text'=>'Home') );
	Helper::endPage('home');	

	Helper::beginPage( array('id'=>'mycharities', 'data-title'=>'My Charities') );?>
		<p class="cn-centered">Access your saved charities once you log in to your account.</p><?php
	Helper::endPage('mycharities');	
	?>

	<script src="/assets/js/jsrender.js"></script>

	<script id="logoTemplate" type="text/x-jsrender">
		<div class="logo">
			<img src="/assets/images/logo.png"/>
		</div>
	</script>

	<script id="toptenlistTemplate" type="text/x-jsrender">
		{{for tmpl="#logoTemplate"/}}
		<p>{{:description}}</p>
		<ul data-role="listview" data-inset="true">
			{{for orgs}}
				<li><a href="#organization/{{>slug}}">{{>name}} <span class="ui-li-count" title="{{>value_label}}">{{>value}}</span></a></li>
			{{/for}}		
		</ul>
	</script>

	<script id="organizationTemplate" type="text/x-jsrender">
		{{for tmpl="#logoTemplate"/}}
		<h2>{{>name}}</h2>
		<p>{{:mission}}</p>
	</script>


	<script id="hottopicTemplate" type="text/x-jsrender">
		{{for tmpl="#logoTemplate"/}}
		<h2>{{>name}}</h2>
	</script>


	<script id="listItemTemplate" type="text/x-jsrender">
		{{for tmpl="#logoTemplate"/}}
		<h2>{{>name}}</h2>
		<p>{{:description}}</p>
	</script>

    <script src="/assets/js/jquery.validate.js"></script>

	<script type="text/javascript">

	if(!window.CharityNavigator){

	    window.CharityNavigator = (function(){


	        var CharityNavigator = {

		        DELAY: 1500,
		        cache: null,
		        lastKeyword: '',
		        timeoutId: 0,

	            log: function(msg){
	                if( console && console.log )
	                    console.log(msg);
	            },

	            init: function(){

	                $me = this;

	                $(document).live('pagebeforechange', function(event,ui){
	                    CharityNavigator.pagebeforechangeHandler(event,ui);
	                });

	                $('#home').live("pageshow", function(event, ui){
	                    CharityNavigator.pageshowHandler(event, ui);
	                });              

                	$('#loginsubmit').live('tap', function(e){ 
                		$me.authenticate.call($me); 
                	});

                	$('#registersubmit').live('tap', function(e){ 
                		$me.register.call($me); 
                	});

	                $.when( $.getJSON('/api2/organizations') ).then(function($result){
	                	$me.cache = $result.data;
	               	}, function(){
	                	CharityNavigator.log('CharityNavigator.init FAILED TO DOWNLOAD cache');	                	
	                });

					$('#registrationform').validate({
						rules: {
							registername: {
								required: true,
								minlength: 2
							},
							registeremail: {
								required: true,
								email: true
							},
							registerpassword: {
								required: true,
								minlength: 6
							}
						},

						highlight: function(label) {
    						$(label).html('validation-error');
  						}

					});
	            },

	            pagebeforechangeHandler: function(e, ui){
	                
	                CharityNavigator.log('CharityNavigator.pagebeforechangeHandler');

	                if( typeof ui.toPage === 'string'){
	                    var url = $.mobile.path.parseUrl( ui.toPage );
	                    CharityNavigator.log('CharityNavigator.pagebeforechangeHandler - directory ' + url.directory);
	                    
	                    if( url.directory === '/organization/' ){
	                        CharityNavigator.organizationHandler(e, ui, url, url.directory, url.filename);
	                    }
	                    else if( url.directory === '/toptenlist/' ){
	                        CharityNavigator.itemHandler({
	                        	e: e, 
	                        	ui: ui, 
	                        	url: url, 
	                        	action: url.directory, 
	                        	slug: url.filename,
	            				pageId: '#toptenlist',
	            				templateId: '#toptenlistTemplate'
	                        });
	                    }
	                    else if( url.directory === '/hottopic/' ){
	                        CharityNavigator.itemHandler({
	                        	e: e, 
	                        	ui: ui, 
	                        	url: url, 
	                        	action: url.directory, 
	                        	slug: url.filename,
	            				pageId: '#hottopic',
	            				templateId: '#hottopicTemplate'
	                        });
	                    }
	                    else if( url.directory === '/tip/' ){
	                        CharityNavigator.itemHandler({
	                        	e: e, 
	                        	ui: ui, 
	                        	url: url, 
	                        	action: url.directory, 
	                        	slug: url.filename,
	            				pageId: '#tip',
	            				templateId: '#listItemTemplate'
	                        });
	                    }
	                }
	            },

	            itemHandler: function($options){
	                
	                CharityNavigator.log('CharityNavigator.itemHandler.' + $options.action + '.' + $options.slug);
	                
	                $options.e.preventDefault();

	                $.when( $.getJSON('/api2' + $options.action + $options.slug) )
	                 .then( function( result ){

	                    var $page = $($options.pageId);
	                    var $header = $page.children( ":jqmData(role=header)" );
	                    var $content = $page.children( ":jqmData(role=content)" );
	                    
	                    $header.find( "h1" ).html( result.data.name );
	                    $content.html( $($options.templateId).render( result.data ) );
	                    $page.page();
	                    $content.find( ":jqmData(role=listview)" ).listview();

	                    $.mobile.changePage( $page );
	                },

	                CharityNavigator.downloadFailed );
	            },

	            organizationHandler: function(e, ui, url, action, slug){
	                
	                CharityNavigator.log('CharityNavigator.organizationHandler');
	                
	                e.preventDefault();

	                $.when( $.getJSON('/api2'+action+slug) )
	                 .then( function( result ){

	                    var $page = $('#organization');
	                    var $header = $page.children( ':jqmData(role=header)' );
	                    var $content = $page.children( ':jqmData(role=content)' );

	                    $header.find( 'h1' ).html( result.data.name );
	                    $content.html( $('#organizationTemplate').render(result.data) );
	                    $page.page();

	                    $.mobile.changePage( $page );
	                },

	                CharityNavigator.downloadFailed );
	            },

	            downloadFailed: function( result ){
	                CharityNavigator.log('CharityNavigator.downloadFailed');
	            },

	            timeoutHandler: function(){
	                CharityNavigator.onTimeout.call(CharityNavigator);
	            },

	            pageshowHandler: function(event, ui){
	                if( this.lastKeyword ){
	                    $("#search").val( this.lastKeyword );
	                    this.lastKeyword = '';
	                }
	                if( !this.timeoutId ){
	                    this.timeoutId = window.setTimeout( CharityNavigator.timeoutHandler, this.DELAY );
	                }
	            },

	            onTimeout: function(){
	            	//this.log('CharityNavigator.onTimeout');
	                if( $.mobile.activePage['0'].dataset.title === 'Home' ){
	                    this.refreshList();  
	                    this.timeoutId = window.setTimeout( CharityNavigator.timeoutHandler, this.DELAY );
	                } else {
	                    this.timeoutId = 0;
	                }
	            },

	            refreshList: function(){
	                var keyword = $("#search").val();
	                if( this.lastKeyword !== keyword ){
	                    this.log('CharityNavigator.refreshList NEW SEARCH with ' + keyword);
	                    this.lastKeyword = keyword;
	                    $('#search-results').empty();
	                    if( keyword ){
	                        var pattern = keyword.length > 2 ? new RegExp(keyword, 'i') : new RegExp('^'+keyword, 'i');
	                        var cache = this.cache;
	                        for(var i=0, j=cache.length; i<j; i++ ){
	                            var item = cache[i];
	                            if( pattern.test(item.name) ){
	                                $('#search-results').append('<li><a href="#organization/'+item.slug+'">'+item.name+'</a></li>');    
	                            }
	                        }
	                    }
	                    $('#search-results').listview('refresh');
	                }
	            },

	            authenticate: function(){
	                this.log('CharityNavigator.authenticate');
	                
	                $me = this;
	                $.post('/api2/authenticate', { 
	                		'email': $('#loginemail').val(), 
	                		'password': $('#loginpassword').val()
	                	}, 
	                    function(data){
	                        if( data.success === false ){
	                        }
	                        else {
	                            $me.authenticated = true;
	                            $me.user = data.data;
	                            $.mobile.changePage('#mycharities');
	                        }
	                    }, 'json');
	                return false;
	            },

	            register: function(){

	            	$('#registrationform').valid();

	                return false;
	            }

	        };
	        return CharityNavigator;
	    })();

	    CharityNavigator.init();
	}

	</script>

</body>
</html>

