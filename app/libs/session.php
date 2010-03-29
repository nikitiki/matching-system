<?php
/**
 *
 */
class Session
{

    public function __construct() {}

    public function startup() {
        $this->open();
    }

    public function open() {
        session_start();
    }

    public function close() {
        if( session_id() !== '' )
            @session_write_close();
    } 

    public function destroy() {
        if( session_id() !== '' ) {
            @session_unset();
            @session_destroy();
        }
    }

    public function getIsStarted() {
        return session_id() !== '';
    }

    public function getSessionId() {
        return session_id();
    }

    public function setSessionId( $value ) {
        session_id( $value );
    }

    public function getSessionName() {
        return session_name();
    }

    public function setSessionName( $value ) {
        session_name( $value );
    }

    public function getCookieParams() {
        return session_get_cookie_params();
    }

    // @praram array cookie parameters, valid keys include: ifetime, path, domain, secure,
    public function setCookieParams( $value ) {
        $data = session_get_cookie_params();
        extract( $data );
        extract( $value );
        if( isset( $httponly ) )
            session_set_cookie_params( $lifetime, $path, $domain, $secure, $httponly );
        else
            session_set_cookie_params( $lifetime, $path, $domain, $secure );
    }

    public function getCookieMode() {
        if( ini_get( 'session.use_cookies' ) === '0' ) 
            return 'none';
        else if( ini_get( 'session_use_only_cookies' ) === '0' )
            return 'allow';
        else
            return 'only';
    }

    public function setCookieMode( $value ) {
        if( $value === 'none' )
            ini_set( 'session.use_cookies', '0' );
        else if( $value === 'allow' ) {
            ini_set( 'session.use_cookies', '1' );
            ini_set( 'session.use_only_cookies', '0' );
        } 
        else if( $value === 'only' ) {
            ini_set( 'session.use_cookies', '1' );
            ini_set( 'session.use_only_cookies', '1' );
        }
    }

    public function getUseTransparentSessionId() {
        return ini_get( 'session.use_trans_sid' ) == 1;
    }

    public function setUseTransparentSessionId( $value ) {
        ini_set( 'session.use_trans_sid', $value ? '1' : '0' );
    }

    public function getCount() {
        return count( $_SESSION );
    }

    public function getKeys() {
        array_keys( $_SESSION );
    }

    public function itemAt( $key ) {
        return isset( $_SESSION[$key] ) ? $_SESSION[$key] : null;
    }

    public function add( $key, $value ) {
        $_SESSION[$key] = $value;
    }

    public function remove( $key ) {
        if( isset( $_SESSION[$key] ) ) {
            $value = $_SESSION[$key];
            unset( $_SESSION[$key] );
            return $value;
        }
        else
            return null;
    }

    public function contains( $key ) {
        return isset( $_SESSION[$key] );
    }

    public function toArray() {
        return $_SESSION;
    }
}
?>
