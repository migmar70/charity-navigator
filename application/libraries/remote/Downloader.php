<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class CN_Downloader {

	var $app_id;
	var $app_key;
    var $folder;

    public function __construct($app_id, $app_key, $version){
        $this->app_id = $app_id;
        $this->app_key = $app_key;
        $this->folder = FCPATH.'public/content/cache/'.$version.'/';
    }

    public function downloadXml( $api, $namefield, $params ){

        $data = array();

        $xmlDoc = $this->_readFromCache( $api, $params  );
        if( $xmlDoc == null ){
            $xmlDoc = $this->download( $api, $params );    
        }

        foreach ($xmlDoc->objects->object as $object) {

            if( $api === 'celebrities' ||  $api === 'celebrity-orgs' ){
                if( $object->lname == 'Leoni' ){
                    $object->fname = 'Téa';
                }
            }

            if( $api === 'celebrities' ){
                $object->{$namefield} = CN_Common::namefy( $object->fname, $object->mname, $object->lname );
            }

            if( $api === 'celebrity-orgs' ){
                $object->{$namefield} = CN_Common::namefy( $object->fname, $object->mname, $object->lname ).' '.$object->charity_name.' '.$object->relationship;
            }

            $object->{'slug'} = CN_Common::slugify((string)$object->{$namefield});
            $data[] = $object;
        }
        return $data;
    }

    public function download( $api, $params ){

        $xmlDoc = new SimpleXMLElement( "<response><objects/></response>" );
        $this->_apidownload( $api, $xmlDoc, $params );
        $this->_saveToCache( $api, $xmlDoc, $params );
        return $this->_readFromCache( $api, $params );
    }
    
    private function _apidownload( $api, &$xmlData, $params ){
        if( $api === 'country-orgs' && $params != null && count($params) > 0 ){
            $url = 'http://api.charitynavigator.org/api/v1/'.$api.'/'.$params['countryid'].'/?app_id='.$this->app_id.'&app_key='.$this->app_key.'&format=xml';
            $params = null;
        }
        else {
            $url = 'http://api.charitynavigator.org/api/v1/'.$api.'/?app_id='.$this->app_id.'&app_key='.$this->app_key.'&format=xml';    
        }
        
        if( $api === 'lists' || $api === 'categories' || $api === 'causes' || $api === 'celebrities' || $api === 'country-orgs'){
            $url .= '&offset=0&limit=100';
        }
        if( $params != null){
            foreach ($params as $key => $value) {
                $url .= '&'.$key.'='.$value;
            }
            //die($url);
        }
        $this->_download( $api, $url, $xmlData );
    }

    private function _download( $api, $url, &$xmlData ){

        echo "<p>$url</p>";

        $connection = curl_init(); 
        curl_setopt($connection, CURLOPT_URL, $url );
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($connection);
        curl_close($connection);

        $xmlDoc = simplexml_load_string( $output );

        foreach ($xmlDoc->objects->object as $object) {
            $xmlElement = $xmlData->objects->addChild( 'object' );
            foreach ($object->children() as $child) {
                $name = $child->getName();
                $value = htmlspecialchars( (string)$object->{$name} );
                //echo 'xmlData->objects->addChild ' . $name. '<br/>';
                //echo $value. '<br/>';
                $xmlElement->addChild( $name, utf8_encode($value) );
            }
        }

        $next = (string)$xmlDoc->meta->next;
        if( strlen($next) > 0 ){
            $this->_download( $api, $next, $xmlData );
        }
    }

    private function _readFromCache( $api, $params  ){
        $xmlDoc = null;
        $slug = CN_Common::slugify($api);
        if( $params != null){
            foreach ($params as $key => $value) {
                $slug .= '-'.CN_Common::slugify("$key $value");
            }
        }
        $filespec = $this->folder . $slug . '.xml';
        if( file_exists($filespec) ){
            echo "Reading from cache $filespec...<br/>";
            $xmlDoc = simplexml_load_file($filespec);
        }
        return $xmlDoc;
    }

    private function _saveToCache( $api, &$xmlDoc, $params  ){
        $slug = CN_Common::slugify($api);
        if( $params != null){
            foreach ($params as $key => $value) {
                $slug .= '-'.CN_Common::slugify("$key $value");
            }
        }
        $filespec = $this->folder . $slug . '.xml';
        echo "Saving to cache $filespec...<br/>";
        $file = fopen($filespec, 'w');
        fwrite($file, $xmlDoc->asXML());
        fclose($file);
    }
}
