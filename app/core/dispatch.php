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

        // コントローラーにDB定義
//        $c->setDatabase( $db );

        // 指定コントローラーインスタンス生成
        $c->dispatch();

        // 指定コントローラーbeforefilter実行
        $c->beforeFilter();

        // 指定アクション実行
        $c->execute();

        // 指定コントローラーafterFilter実行
        $c->afterFilter();


        // View設定
        $v = new View_Manager( $c, $request );

        // 指定ビューファイル設定
        $v->setFile();

        // 指定ビューファイル実行
        $v->dispatch();

    }

}
?>
