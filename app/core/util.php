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
     * URLのHOST部分を取得
     */
    public function getHostInfo( $schema = '' ) {

        // httpかhttpsか
        if( $secure = $this->getIsSecureConnection() ) 
            $http = 'https';
        else
            $http = 'http';

        if( isset( $_SERVER['HTTP_HOST'] ) ) {

            $hostInfo = $http . '://' . $_SERVER['HTTP_HOST'];

        } else {

            $hostInfo = $http . '://' . $_SERVER['SERVER_NAME'];

            // 接続ポート取得
            $port = $_SERVER['SERVER_PORT'];

            // ポート設定
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
     * @return boolean セキュアモードであればtrue
     */
    public function getIsSecureConnection() {
        return isset( $_SERVER['HTTPS'] ) && !strcasecmp( $_SERVER['HTTPS'], 'on'  );
    }

}
?>
