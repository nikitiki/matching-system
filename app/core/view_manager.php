<?php
/**
 * 指定ファイル実行クラス
 */
class View_Manager
{

    /**
     * レイアウトテンプレート格納
     */
    private $template;


    /**
     * 指定テンプレート
     */
    private $viewfile;


    /**
     * コントローラーマネージャーオブジェクト
     */
    private $con_mng_obj;


    /**
     * 実行コントローラーオブジェクト
     */
    private $con_obj;


    /**
     * リクエストオブジェクト
     */
    private $request_obj;
    

    /**
     * コンストラクタ
     */
    public function __construct( &$controller_object, &$request_object ) {

        $this->con_mng_obj = $controller_object;
        $this->con_obj     = $controller_object->getCon_obj();
        $this->request_obj = $request_object;

    }


    // {{{ setFile
    /**
     * 実行ビューファイル格納
     */
    public function setFile() {

        // レイアウトテンプレート取得
        $template = $this->con_obj->getTemplate();

        // テンプレート名から拡張をはずす
        $temlate = basename( $template );

        // 小文字に変換
        $template = strtolower( $template );

        // テンプレートファイルパス取得
        $this->template = APP_VIEWS_LAYOUT_PATH . '/' . $template . '.php';

        // コントローラー名取得
        $controller = $this->con_obj->getController();

        // アクション名取得 
        $view = $this->con_obj->getAction();

        // ビューファイルパス取得
        $this->viewfile = APP_VIEWS_PATH . $controller . '/' . $view . '.php';

        // 実行ビュー存在チェック
        if( file_exists( $this->viewfile ) == false ) {

            // @TODO 日本語メッセージ別ファイルに定義
            trigger_error( '指定したテンプレートが存在しません', E_USER_NOTICE );
            exit;
        }

    }
    // }}}


    // {{{ dispatch
    /**
     *
     */
    public function dispatch() {

        // レイアウトテンプレートがセットされているか
        if( file_exists( $this->template ) ) {

            $this->display_template();

        } else {

            $this->content();

        }

    }
    // }}}


    // {{{ content
    /**
     *
     */
    public function content() {

        // コントローラーでセットした変数を取得
        $variables = $this->request_obj->getParams();

        // 無害化
        $variables = $this->outputFilter( $variables );

        // セットした名前で変数を利用
        extract( $variables, EXTR_SKIP );

        require_once( $this->viewfile );

    }
    // }}}


    // {{{ display_template
    /**
     *
     */
    public function display_template() {

        // コントローラーでセットした変数を取得
        $variables = $this->request_obj->getParams();

        // 無害化
        $variables = $this->outputFilter( $variables );

        // セットした名前で変数を利用
        extract( $variables, EXTR_SKIP );

        // 指定ファイル読み込み
        require_once( $this->template );

    }
    // }}}

    // {{{
    /**
     * 
     */
    private function outputFilter( $param ) {

        if( is_array( $param ) ) {

            // 配列の場合は再帰的に実行
            return array_map( array( $this, 'outputFilter' ), $param );

        } else {

            // HTMLタグやJavaScriptタグを無効化する
            return htmlspecialchars( $param, ENT_QUOTES );
        }
    }
    // }}}

}
?>
