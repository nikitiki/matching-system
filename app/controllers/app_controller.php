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
     *  自動ログイン
     */
    public function login_from_cookie() {

        // クッキーが設定されているか　
        if( isset( $_COOKIE['auth_token'] ) && 
            !empty( $_COOKIE['auth_token'] ) && 
            !$this->isLogin() ) {

            // ユーザモデル読み込み
            include_once( APP_MODELS_PATH . 'team.php' );

            // クッキーを元の形に戻す
            $cookies = unserialize( $_COOKIE['auth_token'] );

            // ユーザ情報からクッキートークンを取得
            $obj = new Team();
            $obj->table_name = 'team';
            $team = $obj->find( array( ':remember_token' => $cookies['value']), 'WHERE remember_token = :remember_token' );

            // ユーザ情報が存在かつクッキーが有効なら
            if( $team && $this->auth->remember_token( $team[0]['remember_token_expires_at'] ) ) {

                // クッキーを更新
                $token_key = $this->auth->_enableRememberMe();

                // DBにあるクッキー情報を更新
                $team =  $obj->remember_me( $team[0]['id'], $token_key );

                // セッションにユーザ情報登録
                $this->session->add( 'team', $team[0] );

                // セッションフラグ有効化
                $this->session->add( 'is_login', 1 );
            }
        }
    }
    // }}}

    // {{{ isLogin
    /**
     * ログインしているかどうか
     */
    function isLogin() {

        if( $this->session->getIsStarted() && $this->session->itemAt( 'is_login' ) == 1 ) {

            // セッション情報取得
            $s_team = $this->session->itemAt( 'team' );

            // ユーザモデル読み込み
            include_once( APP_MODELS_PATH . 'team.php' );

             // セッション情報からユーザ情報取得
            $obj = new Team();
            $obj->table_name = 'team';
            $team = $obj->find( array( ':id' => $s_team['id'] ), 'WHERE id = :id' );

            // セッション情報破棄
            $this->session->remove( 'team' );

            // セッション再登録
            $this->session->add( 'team', $team[0] );

            return true;
        }
        return false;
    }
    // }}}

}
?>
