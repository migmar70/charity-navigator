<?php 
class Helper {

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
                <a href="#loginpage" data-role="button" class="ui-btn-right cn-login">Login</a><?php
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
                <li><a href="/" data-icon="home" <?php if($navbar==='home'):?>class="ui-btn-active ui-state-persist"<?php endif;?> >Home</a></li>
                <li><a href="#search" data-icon="search" <?php if($navbar==='search'):?>class="ui-btn-active ui-state-persist"<?php endif;?> >Search</a></li>
                <li><a href="#mycharities" data-icon="star" <?php if($navbar==='mycharities'):?>class="ui-btn-active ui-state-persist"<?php endif;?> >My Charities</a></li>
            </ul>
        </div><!-- /navbar --><?php
	}
}?>
