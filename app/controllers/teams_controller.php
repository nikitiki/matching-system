<?php
/**
 * チーム登録
 *
 */
class TeamsController extends AppController {

    // テンプレート設定
    var $layout = 'default';

    // モデル設定
    var $use = array( 'team' );


    // {{{ index
    /**
     * チーム一覧画面
     */
    public function index() {

    }
    // }}}


    // {{{ add
    /**
     * チーム登録フォーム画面
     */
    public function add() {

    }
    // }}}
    

    // {{{ create
    /**
     * チーム登録
     */
    public function create() {

        // 不要文字削除
        $this->request->data['team']['login_id'] = trim( preg_replace('/[\x00\x1f:<>&%,;]+/', '', $this->request->data['team']['login_id'] ) );
        $this->request->data['team']['email'] = trim( preg_replace( '/[\x00\x1f:<>&%,;]+/', '', $this->request->data['team']['email'] ) );


        // バリデーション実行
//        if( !$res = $this->team->validation( $this->request->data ) ) {

            // エラーメッセージ取得
//            $error_msgs = $this->team->error_msg;

            // エラーメッセージセット
//            $this->set( 'error_msg', $error_msgs );

            // 入力画面に戻る
            $this->render( array( 'action' =>  'add' ) );
//        }

        // 正常に処理終了したらリダイレクト
//        $this->util->redirect( '/teams/index' );


    }
    // }}}
}
?>
