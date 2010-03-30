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

        $remember_me_key = sha1( uniqid() . mt_rand( 1, 999999999 ) );

        setCookie( 'remember_me', $remember_me_key, time() + $this->auto_login_expiry, '/' );
    }
    // }}}


    // {{{
    /**
     * 自動ログインを破棄する
     */
    public function _disableRememberMe() {

        // そもそもクッキーが設定されていなかったら無視
        if( empty( $_COOKIE['remember_me'] ) ) {
            return;
        }

        // クッキーの破棄
        setcookie( 'remember_me', '', time() - 3600, '/' );
    }
    // }}}
}
?>
