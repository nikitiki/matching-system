<?php
/**
 * エントリポイント
 *
 */
class TDispatch
{

    function dispatch() {

        // DB初期化
        $db =  new TDatabase;

        // URI解析処理 リクエストパラメータ初期化処理 
        $request = new Request;
 
        // コントローラーインスタンス生成
        $c = new Controller_Manager( $request );

        // 指定コントローラーインスタンス生成
        $c->dispatch();

        // 指定コントローラーbeforefilter実行
        $c->beforecFilter();

        // 指定アクション実行
        $c->execute();

        /**
         * View設定
         */
//        View_Manager::dispatch( $viewName );

    }

}
?>
