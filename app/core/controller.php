<?php
class Controller
{

    protected $con_mng;

    protected $request;

    protected $template;

    protected $use;

    protected $util;

    public $helper;

    public $controller;

    public $action;

    // {{{
    /**
     * コンストラクタ
     */
    public function __construct( &$con_mng ){ 

        // コントローラーマネージャー格納
        $this->con_mng = $con_mng;

        // リクエストオブジェクト格納
        $this->request = $con_mng->getRequest_obj();

        // 実行コントローラー格納
        $this->controller = $con_mng->getControllerName();

        // モデル初期化
        $this->addModel();

        // テンプレート初期化
        $this->setTemplateInit();

        // ユーティリティークラス読み込み
        $this->util = new AppUtil();

    }
    // }}}

    // {{{ init
    /**
     * アクション実行前初期処理
     */
    public function startup() {

        // 実行アクション名格納
        $this->setAction( $this->con_mng->getActionName() );
    }

    // {{{ addMoel
    /**
     * addModel
     */
    private function addModel() {

        if( !empty( $this->use ) ) {

            foreach( $this->use as $model ) {

                // 先頭だけ大文字に
                $model_class = ucfirst( $model );

                // モデルのパス
                $model_path = APP_MODELS_PATH . $model . '.php';

                // モデルファイル存在チェック
                if( !file_exists( $model_path ) ) {
                    // @TODO 
                    trigger_error( '指定したモデルがありません', E_USER_NOTICE);
                    continue;
                } 

                // モデル読み込み
                include_once( $model_path );

                // モデルインスタンス生成
                $class = new $model_class();

                if( empty( $this->{$model} ) ) $this->{$model} = $class;

            }

        }

    }
    // }}}


    // {{{ setTemplateInit
    /**
     * レイアウト初期化
     */
    public function setTemplateInit() {

         if( !empty( $this->layout ) ) {
             $this->setTemplate( $this->layout );
         }
    }
    // }}}


    // {{{ render
    /**
     * 処理委譲
     */
    protected function render( $url = null ) {

        // 
        if( empty( $url ) || 
            ( isset( $url['action'] ) && empty( $url['action'] ) ) 
        ) {
            return;
        }

        // コントローラーがセットされていたら設定
        if( isset( $url['controller'] ) && !empty( $url['controller'] ) ) {

            $this->setController( $url['controller'] );

        }

        // アクション設定
        $this->setAction( $url['action'] );

    }
    // }}}


    // {{{
    /**
     * アクション実行前処理
     */
    public function beforeFilter(){}
    // }}}

    // {{{
    /**
     * アクション実行後処理
     */
    public function afterFilter(){}
    // }}}

    /**
     * レイアウト用テンプレート格納
     */
    public function setTemplate( $template ) {

        $this->template = $template;

    }

    /**
     * レイアウト用テンプレート取得
     */
    public function getTemplate() {
        return $this->template;
    }


    /**
     * 実行コントローラー名セット
     */
    public function setController( $controller ) {
        $this->controller = $controller;
    }

    /**
     * 実行コントローラー名取得
     */
    public function getController() {
        return $this->controller;
    }

    /**
     * 実行アクション名セット
     */
    public function setAction( $action ) {
        $this->action = $action;
    }

    /**
     * 実行アクション名取得
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * 指定アクションがなかった場合このアクションを実行する
     */
    public function error() {

        // @TODO 日本語メッセージ別ファイルに定義
        trigger_error( '指定したアクションがありません', E_USER_ERROR );

    }
}
?>
