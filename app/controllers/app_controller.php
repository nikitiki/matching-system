<?php
class AppController extends Controller
{
    public $app_comp = array( 'session', 'auth' );

    // {{{ isLogin
    /**
     * $B%m%0%$%s$7$F$$$k$+$I$&$+(B
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
