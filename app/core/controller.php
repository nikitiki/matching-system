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
