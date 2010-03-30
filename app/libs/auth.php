<?php
/**
 *
 */
class Auth
{ 

    /**
     * クッキーの有効時間
     */
    public $auto_login_expiry = AUTO_LOGIN_EXPIRY; // 一週間


    // {{{
    public function startup() {}
    // }}}


    // {{{ _enableAutoLogin
    /**
     * 自動ログインを設定する
     */
    public function _enableRememberMe() {

        $this->_disableRememberMe();

        $remember_me_key = sha1( uniqid() . mt_rand( 1, 999999999 ) );
        $expries_at = time() + $this->auto_login_expiry;

        $cookies = array(
                          'value' => $remember_me_key,
                          'expires_at' => $expries_at
                   );

        // クッキーは文字列しか格納できないのでシリアライズ
        $cookies = serialize( $cookies );

        setCookie( 'auth_token', $cookies, time() + $expries_at, '/' );

        return $remember_me_key;
    }
    // }}}


    // {{{
    /**
     * 自動ログインを破棄する
     */
    public function _disableRememberMe() {

        // そもそもクッキーが設定されていなかったら無視
        if( empty( $_COOKIE['auth_token'] ) ) {
            return;
        }

        // クッキーの破棄
        setcookie( 'auth_token', '', time() - 3600, '/' );
    }
    // }}}


    // {{{
    /**
     * クッキー情報は有効期限内か
     */
    public function remember_token( $expires_at = null ) {

        if( is_null( $expires_at ) || empty( $expires_at ) ) {
            return false;
        }

        $now = time();

        return $now < $expires_at;
    }
    // }}}

}
?>
