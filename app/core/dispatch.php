<?php
/**
 * エントリポイント
 *
 */
class TDispatch
{

    function dispatch() {

        $db =  new TDatabase;

        /**
         * Action設定
         */

         $c = new Controller_Manager;

         var_dump( $c->getController() );

        /**
         * View設定
         */
//        View_Manager::dispatch( $viewName );

    }

}
?>
