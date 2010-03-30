<?php
class AppController extends Controller
{
    public $app_comp = array( 'session', 'auth' );


    // {{{ 
    public function beforeFilter() {
        $this->login_from_cookie();
    }
    // }}}

    // {{{ login_from_cookie
    /**
     *  $B<+F0%m%0%$%s(B
     */
    public function login_from_cookie() {

        // $B%/%C%-!<$,@_Dj$5$l$F$$$k$+!!(B
        if( isset( $_COOKIE['auth_token'] ) && 
            !empty( $_COOKIE['auth_token'] ) && 
            !$this->isLogin() ) {

            // $B%f!<%6%b%G%kFI$_9~$_(B
            include_once( APP_MODELS_PATH . 'team.php' );

            // $B%/%C%-!<$r85$N7A$KLa$9(B
            $cookies = unserialize( $_COOKIE['auth_token'] );

            // $B%f!<%6>pJs$+$i%/%C%-!<%H!<%/%s$r<hF@(B
            $obj = new Team();
            $obj->table_name = 'team';
            $team = $obj->find( array( ':remember_token' => $cookies['value']), 'WHERE remember_token = :remember_token' );

            // $B%f!<%6>pJs$,B8:_$+$D%/%C%-!<$,M-8z$J$i(B
            if( $team && $this->auth->remember_token( $team[0]['remember_token_expires_at'] ) ) {

                // $B%/%C%-!<$r99?7(B
                $token_key = $this->auth->_enableRememberMe();

                // DB$B$K$"$k%/%C%-!<>pJs$r99?7(B
                $team =  $obj->remember_me( $team[0]['id'], $token_key );

                // $B%;%C%7%g%s$K%f!<%6>pJsEPO?(B
                $this->session->add( 'team', $team[0] );

                // $B%;%C%7%g%s%U%i%0M-8z2=(B
                $this->session->add( 'is_login', 1 );
            }
        }
    }
    // }}}

    // {{{ isLogin
    /**
     * $B%m%0%$%s$7$F$$$k$+$I$&$+(B
     */
    function isLogin() {

        if( $this->session->getIsStarted() && $this->session->itemAt( 'is_login' ) == 1 ) {

            // $B%;%C%7%g%s>pJs<hF@(B
            $s_team = $this->session->itemAt( 'team' );

            // $B%f!<%6%b%G%kFI$_9~$_(B
            include_once( APP_MODELS_PATH . 'team.php' );

             // $B%;%C%7%g%s>pJs$+$i%f!<%6>pJs<hF@(B
            $obj = new Team();
            $obj->table_name = 'team';
            $team = $obj->find( array( ':id' => $s_team['id'] ), 'WHERE id = :id' );

            // $B%;%C%7%g%s>pJsGK4~(B
            $this->session->remove( 'team' );

            // $B%;%C%7%g%s:FEPO?(B
            $this->session->add( 'team', $team[0] );

            return true;
        }
        return false;
    }
    // }}}

}
?>
