<?php
class Util {

    public function __construct() {}


    // {{{{ redirect
    /**
     * redirect
     */
    public function redirect( $url, $statusCode = 302 ) {

        if( strpos( $url, '/' ) === 0 ) 
            $url = $this->getHostInfo() . $url;

        header( "Location:" . $url, true, $statusCode );
        exit();
    }
    // }}}


    // {{{ getHostInfo
    /**
     * URL$B$N(BHOST$BItJ,$r<hF@(B
     */
    public function getHostInfo( $schema = '' ) {

        // http$B$+(Bhttps$B$+(B
        if( $secure = $this->getIsSecureConnection() ) 
            $http = 'https';
        else
            $http = 'http';

        if( isset( $_SERVER['HTTP_HOST'] ) ) {

            $hostInfo = $http . '://' . $_SERVER['HTTP_HOST'];

        } else {

            $hostInfo = $http . '://' . $_SERVER['SERVER_NAME'];

            // $B@\B3%]!<%H<hF@(B
            $port = $_SERVER['SERVER_PORT'];

            // $B%]!<%H@_Dj(B
            if( ( $port != 80 && !$secure ) || ( $port != 443 && $secure ) ) {
                $hostInfo .= ':' . $port;
            }
        }

        if( $schema !== '' && ( $pos = strpos( $hostInfo, ':' ) !== false ) ) 
            return $shema . substr( $hostInfo, $pos );
        else 
            return $hostInfo;
    }
    // }}}


    // {{{ getIsSecureConnection
    /**
     * @return boolean $B%;%-%e%"%b!<%I$G$"$l$P(Btrue
     */
    public function getIsSecureConnection() {
        return isset( $_SERVER['HTTPS'] ) && !strcasecmp( $_SERVER['HTTPS'], 'on'  );
    }

}
?>
