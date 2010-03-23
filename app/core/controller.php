<?php
class Controller
{

    protected $request;

    protected $template;

    protected $use;

    /**
     * コンストラクタ
     */
    public function __construct( &$request ){ 

        // リクエストオブジェクト格納
        $this->request = $request;

        // モデル初期化
        $this->addModel();
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
                $model_path = APP_MODELS_PATH . $model . 'php';

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

                if( empty( $this->{$model} ) ) $this->{$model} = &$class;

            }

        }

    }
    // }}}

    /**
     * アクション実行前処理
     */
    public function beforeFilter(){}


    /**
     * アクション実行後処理
     */
    public function afterFilter(){}


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
     * 指定アクションがなかった場合このアクションを実行する
     */
    public function error() {

        // @TODO 日本語メッセージ別ファイルに定義
        trigger_error( '指定したアクションがありません', E_USER_ERROR );

    }

}
?>
