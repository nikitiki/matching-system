<?php
/**
 * チーム
 *
 */
class TeamsController extends AppController {

    // テンプレート設定
    var $layout = 'default';

    // モデル設定
    var $use = array( 'team', 'prefecture' );

    // ヘルパー定義
    var $helper = array( 'prefecture' );


    // {{{
    public function beforeFilter() {
        parent::beforeFilter();
    }
    // }}}

    // {{{ index
    /**
     * チーム一覧画面
     */
    public function index() {

        // チーム一覧取得
        $this->request->set( 'teams', $this->team->find() );
    }
    // }}}


    // {{{ add
    /**
     * チーム登録フォーム画面
     */
    public function add() {

        // カラム名取得 →テンプレート変数初期化
        $this->request->set( 'data', $this->team->schema() );

    }
    // }}}
    

    // {{{ create
    /**
     * チーム登録
     */
    public function create() {


        // テンプレート設定
        $this->setTemplate( 'nologin' );

        // 送信ボタンで遷移していない場合登録画面に遷移させる
        if( empty( $this->request->data ) ) {
            $this->render( array( 'action' => 'add' ) );
            return;
        }

        // 不要文字削除
        $this->request->data['team']['login_id'] = trim( preg_replace('/[\x00\x1f:<>&%,;]+/', '', $this->request->data['team']['login_id'] ) );
        $this->request->data['team']['email'] = trim( preg_replace( '/[\x00\x1f:<>&%,;]+/', '', $this->request->data['team']['email'] ) );


        // バリデーション実行
        if( !$res = $this->team->validate( $this->request->data ) ) {

            // エラーメッセージ取得
            $error_msgs = $this->team->err_msg;

            // エラーメッセージセット
            $this->request->set( 'error_msgs', $error_msgs );

            // 入力画面に戻る
            $this->render( array( 'action' =>  'add' ) );

            // 入力値をセット
            $this->request->set( 'data', $this->request->data['team'] );

        } else {

            // 保存処理
            $id = $this->team->insert( $this->request->data );

            // メール送信処理
            if( !$res = $this->team->sendVerificationEmail( $id, $this->util->getHostInfo() ) ) {
                trigger_error( 'メール送信失敗しました', E_USER_ERROR );
            } 

            // 正常に処理終了したらリダイレクト
            $this->util->redirect( '/root/index' );

        }
    }
    // }}}

    // {{{ verifiAccount
    /**
     *
     */
    public function verifyAccount() {

        // コードとログインIDのハッシュを取得
        $code = $this->request->getParam( 'code' );
        $login_id_hash = $this->request->getParam( 'l' );

        // ユーザが存在するか確認
        if( $user = $this->team->find( 
            array( ':code' => $code ), 'WHERE code = :code' ) ) {

            $user['team'] = $user[0];
            $user_login_id_hash = MD5( $user['team']['login_id'] );

            // アクティベートされていないか
            if( $login_id_hash == $user_login_id_hash 
               && $user['team']['active_flg'] == false ) {

                // アクティベートする
                $this->team->update( $user );

                // アクティベート成功画面に遷移
                return;
            } 
        }
        // エラー画面に遷移
        $this->render( array( 'action' => 'verifyError' ) );
    }
    // }}}


    //{{{ login
    /**
     * ログイン画面
     */
    public function login() {

        // オートログインチェック
        if( $this->isLogin() ) {

            // トップ画面へリダイレクト
            $this->util->redirect( '/' );
        }

        // GETで
        if( !isset( $this->request->data['team'] ) ) {

            $this->request->set( 'data', $this->team->schema() );

        // POSTで
        } else {

            // ログインIDとパスワードでDB問い合わせ
            if( $res =  $this->team->authenticate( $this->request->data ) ) {

                if( $remember_me = $this->request->getParam( 'remember_me' ) ) {
                    // クッキーにトークンセット
                    $token_key = $this->auth->_enableRememberMe();

                    // DBにあるクッキー情報を更新
                    $this->team->remember_me( $res['id'], $token_key );
                }

                // セッション情報にユーザーID格納
                $this->session->add( 'team', $res );

                // セッションフラグ有効
                $this->session->add( 'is_login', 1 );

                // リダイレクト処理
                $this->util->redirect( '/root/index' );

            }

            // ログイン失敗文言フラッシュセット
            // エラーメッセージ取得
            $error_msgs = $this->team->err_msg;

            // エラーメッセージセット
            $this->request->set( 'error_msgs', $error_msgs );

            // 入力した内容を表示
            $this->request->set( 'data', $this->request->data['team'] );

        }
    }
    // }}}


    // {{{
    /**
     *
     */
    public function logout() {

        // クッキー破棄
        $this->auth->_disableRememberMe();

        // セッション破棄
        $this->session->destroy();

        $this->util->redirect( '/' );
    }
    // }}}

}
?>
