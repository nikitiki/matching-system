<?php
class Util {

    public function __construct() {}


    // {{{{ redirect
    /**
     * redirect
     */
    public function redirect( $url, $is301 = false ) {

         if( $is301 ) {
             header( "HTTP/1.1 301 Moved Permanently" );
         }

        header( "Location:" . $url );
        exit();
    }
    // }}}

}
?>
