<?php
class Controller
{

    var public $request;

    /**
     * コンストラクタ
     */
    public function __construct( &$request ){ 

        $this->request = $request;

    }


    /**
     * アクション実行前処理
     */
    public function beforeFilter(){}


    /**
     * アクション実行後処理
     */
    public function afterFilter(){}


    /**
     * 指定アクションがなかった場合このアクションを実行する
     */
    public function error() {

        // @TODO 日本語メッセージ別ファイルに定義
        trigger_error( '指定したアクションがありません', E_USER_ERROR );

    }

}
?>
