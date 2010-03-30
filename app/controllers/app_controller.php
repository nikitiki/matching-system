<?php
class AppController extends Controller
{
    public $app_comp = array( 'session', 'auth' );

    // {{{ isLogin
    /**
     * ログインしているかどうか
     */
    function isLogin() {

        if( $this->session->getIsStarted() && $this->session->itemAt( 'is_login' ) == 1 ) {
            return true;
        }
        return false;
    }
    // }}}

}
?>
