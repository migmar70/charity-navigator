if(!window.CharityNavigator){

    window.CharityNavigator = (function(){

        var CharityNavigator = {

            log: function(msg){
                if( console && console.log )
                    console.log(msg);
            },

            init: function(){

                $(document).live('pagebeforechange', function(event,ui){
                    CharityNavigator.pagebeforechangeHandler(event,ui);
                });
            },

            pagebeforechangeHandler: function(e, ui){
                
                CharityNavigator.log('CharityNavigator.pagebeforechangeHandler');

                if( typeof ui.toPage === 'string'){
                    var url = $.mobile.path.parseUrl( ui.toPage );
                    CharityNavigator.log('CharityNavigator.pagebeforechangeHandler - directory ' + url.directory);
                    
                    if( url.directory === '/toptenlist/' ){
                        CharityNavigator.toptenlistHandler(e, ui, url, url.directory, url.filename);
                    }

                }
            },

            toptenlistHandler: function(e, ui, url, action, slug){
                
                CharityNavigator.log('CharityNavigator.toptenlistHandler');
                
                e.preventDefault();

                $.when( $.getJSON('/api2'+action+slug) )
                 .then( function( result ){
                    CharityNavigator.log('CharityNavigator.toptenlistHandler_DownloadSuccess');

                    var data = result.data;
                    var orgs = data.orgs;

                    var $page = $('#toptenlist');
                    var $header = $page.children( ":jqmData(role=header)" );
                    var $content = $page.children( ":jqmData(role=content)" );
                    var markup = '<div class="logo"><img src="/assets/images/logo.png"/></div><p>' + data.description + '</p><ul data-role="listview" data-inset="true">';

                    for( var i=0, j=orgs.length; i<j; i++ ) {
                        markup += '<li>' + orgs[i].name + '<span> class="ui-li-count" title="' + orgs[i].value_label.'">' + orgs[i].value + '</span></li>';
                    }
                    markup += '</ul>';

                    $header.find( "h1" ).html( data.name );
                    $content.html( markup );
                    $page.page();
                
                    $content.find( ":jqmData(role=listview)" ).listview();

                    $.mobile.changePage( $page, ui.options );

                },

                CharityNavigator.downloadFailed );
            },

            downloadFailed: function( result ){
                CharityNavigator.log('CharityNavigator.downloadFailed');
            }
        }
        return CharityNavigator;
    })();

    CharityNavigator.init();
}
