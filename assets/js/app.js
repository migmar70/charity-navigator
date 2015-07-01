if(!window.CharityNavigator){

    window.CharityNavigator = (function(){

        var CharityNavigator = {

            DELAY: 1000,
            cache: null,
            lastKeyword: '',
            timeoutId: 0,
            enableShowPageEvent: false,
            authenticated: false,
            user: null,

            log: function(msg){
                console.log(msg);
            },

            init: function(){

                $.mobile.page.prototype.options.domCache = true;

                $('#searchpage').live("pageshow", function(event, ui){
                    CharityNavigator.pageshowHandler(event, ui);
                });              

                $('#searchpage').live("pagehide", function(event, ui){
                    CharityNavigator.pagehideHandler(event,ui);
                });

                $(document).live('pagebeforeshow', function(event,ui){
                    CharityNavigator.pagebeforeshowHandler(event,ui);
                });

                $.when( this.download() )
                 .then( CharityNavigator.downloadSuccess, CharityNavigator.downloadFailed );

                $(document).on('tap','#registerlink', function(){
                    $.mobile.changePage('/account/register');
                });

                $('#loginsubmit').live('tap', function(e){ CharityNavigator.submitLoginForm.call(CharityNavigator); });
                $('#registersubmit').live('tap', function(e){ CharityNavigator.submitRegisterForm.call(CharityNavigator); });
            },

            download: function(){
                return $.getJSON('/api');
            },

            downloadFailed: function( result ){
                CharityNavigator.log('CharityNavigator.downloadFailed');
            },

            downloadSuccess: function( data ){
                CharityNavigator.setCache( data );
            },

            setCache: function( data ){
                this.cache = data;
                this.enableShowPageEvent = true;

                if( !this.timeoutId ){
                    this.pageshowHandler(null,null);
                }
            },

            pageshowHandler: function(event, ui){

                if( this.lastKeyword ){
                    $("#search").val( this.lastKeyword );
                    this.lastKeyword = '';
                }

                if( this.enableShowPageEvent && !this.timeoutId ){
                    this.timeoutId = window.setTimeout( CharityNavigator.timeoutHandler, this.DELAY);
                }
            },

            pagehideHandler: function(event, ui){
                //this.log('CharityNavigator.pagehideHandler');
            },

            timeoutHandler: function(){
                CharityNavigator.onTimeout.call(CharityNavigator);
            },

            onTimeout: function(){
                if( $.mobile.activePage['0'].dataset.title === 'Search' ){
                    this.refreshList();  
                    this.timeoutId = window.setTimeout( CharityNavigator.timeoutHandler, this.DELAY);
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
                        var pattern = new RegExp(keyword, 'i');
                        var cache = this.cache;
                        for(var i=0, j=cache.length; i<j; i++ ){
                            var item = cache[i];
                            if( pattern.test(item.name) ){
                                $('#search-results').append('<li><a href="/organizations/'+item.slug+'">'+item.name+'</a></li>');    
                            }
                        }
                    }
                    $('#search-results').listview('refresh');
                }
            },

            pagebeforeshowHandler: function(event, ui){
                var title = $.mobile.activePage['0'].dataset.title;

                this.log('CharityNavigator.pagebeforeshowHandler - ' + title);
                this.log('CharityNavigator.pagebeforeshowHandler - ' + event.target.attributes.id);
                this.log('CharityNavigator.pagebeforeshowHandler - ' + this.authenticated);

                if( this.authenticated ){
                    $('.cn-login').remove();
                }
            },

            submitLoginForm: function(){
                this.log('CharityNavigator.submitLoginForm');
                this.log( $('#loginform').serialize() );
                $this = this;
                $.post('/account/authenticate', { 'email': $('#login-email').val(), 'password': $('#login-password').val()}, 
                    function(data){
                        if( data.success === false ){

                        }
                        else {
                            $this.authenticated = true;
                            $this.user = data.data;
                            $.mobile.changePage('/mycharities');
                        }
                    }, 'json');
                return false;
            },

            submitRegisterForm: function(){
                this.log('CharityNavigator.submitRegisterForm');
                return false;
            }
        }
        return CharityNavigator;
    })();

    CharityNavigator.init();
}
