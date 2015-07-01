<?php 
class Helper {

    static public function beginHtml( $title ){?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title;?></title>

    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />

    <link rel="stylesheet" href="/assets/css/style.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>

    <script src="/assets/js/app.js" type="text/javascript"></script>
</head>
<body><?php
    }

    static public function endHtml(){?>
</body>
</html><?php
    }    

    static public function beginPage( $options ){?>
        <div data-role="page" <?php
            foreach ($options as $key => $value) {
                if( $key !== 'data-cn-back-btn' && $key !== 'data-cn-nologin-btn' )
                    echo $key.'="'.$value.'" ';
            }
        ?>><?php 
        Helper::writeHeader($options);
    }

    static public function endPage($navbar){
        Helper::writeFooter($navbar);
        echo '</div><!-- /page -->';
    }


	static public function writeHeader( $options ){?>
        <div data-role="header" data-theme="b" data-position="fixed"><?php
            if( isset($options['data-cn-back-btn']) ){
                echo '<a href="'.$options['data-cn-back-btn'].'" data-role="button" class="ui-btn-left">'.$options['data-back-btn-text'].'</a>';
            }?>
            <h1><?php echo $options['data-title'];?></h1><?php
            $showLogin = true;
            if( isset($options['data-cn-nologin-btn']) ){
                if( $options['data-cn-nologin-btn'] == true ){
                    $showLogin = false;
                }
            }
            if( $showLogin ){?>
                <a href="/account/login" data-role="button" class="ui-btn-right cn-login">Login</a><?php
            }?>
        </div><!-- /header -->
        <div data-role="content">   
            <div class="logo">
                <img src="/assets/images/logo.png"/>
            </div><?php
	}

	static public function writeFooter($navbar){?>
        </div><!-- /content -->
        <div data-role="footer" data-position="fixed">
            <?php Helper::writeNavbar($navbar); ?>
        </div><!-- /footer --><?php
	}


	static public function writeNavbar($navbar){?>
        <div data-role="navbar">
            <ul>
                <li><a href="/" data-icon="home" <?php if($navbar==='featured'):?>class="ui-btn-active ui-state-persist"<?php endif;?> >Featured</a></li>
                <li><a href="/browse" data-icon="browse" <?php if($navbar==='browse'):?>class="ui-btn-active ui-state-persist"<?php endif;?> >Browse</a></li>
                <li><a href="/search" data-icon="search" <?php if($navbar==='search'):?>class="ui-btn-active ui-state-persist"<?php endif;?> >Search</a></li>
                <li><a href="/mycharities" data-icon="star" <?php if($navbar==='mycharities'):?>class="ui-btn-active ui-state-persist"<?php endif;?> >My Charities</a></li>
            </ul>
        </div><!-- /navbar --><?php
	}

    static public function celebritiesControlGroup( $activeButton ){?>
        <div data-role="controlgroup" data-type="horizontal" data-mini="true">
            <a href="/celebrities" data-role="button" <?php if($activeButton==='all'):?>class="ui-btn-active"<?php endif;?>>All</a>
            <a href="/celebrities/types" data-role="button" <?php if($activeButton==='types'):?>class="ui-btn-active"<?php endif;?>>Type</a>
            <a href="/celebrities/relationships" data-role="button" <?php if($activeButton==='relationships'):?>class="ui-btn-active"<?php endif;?>>Relation</a>
        </div><?php
    }

    static public function countriesControlGroup( $activeButton ){?>
        <div data-role="controlgroup" data-type="horizontal" data-mini="true">
            <a href="/countries" data-role="button" <?php if($activeButton==='all'):?>class="ui-btn-active"<?php endif;?>>All</a>
            <a href="/countries/regions" data-role="button" <?php if($activeButton==='regions'):?>class="ui-btn-active"<?php endif;?>>Regions</a>
        </div><?php
    }
}
