<?php
/**
 * リクエストハンドラークラス
 * URIの解析、パラメータの格納を担うクラス
 *
 */
class Request
{

    /**
     * コントローラー名
     */
    private $controller;

    /**
     * アクション名
     */
    private $action;

    /**
     * パラメータ格納
     */
    private $params = array();

    /**
     * コンストラクタ
     */
    public function __construct() {

        // URI解析処理
       $this->uri_interpret();

    }

    //{{{ uri_interpret
    /**
     * uri_interpret
     *
     * @access private
     * @return 
     */
    private function uri_interpret() {

        $requestURI = explode( '/', $_SERVER['REQUEST_URI'] );
        $scriptName = explode( '/', $_SERVER['SCRIPT_NAME'] );

        // 前者と後者の差異を比べて後者にないものを取得
        $commandArray = array_diff_assoc( $requestURI, $scriptName );

        // 配列を再配置
        $commandArray = array_values( $commandArray );

        // コントローラー名セット
        $controllerName = ( is_null( $commandArray[0] ) ) ? 'root' : $commandArray[0];
        $this->setController( $controllerName );
        
        // アクション名をセット
        $actionName = ( is_null($commandArray[1]) ) ? 'index' : $commandArray[1];
        $this->setAction( $actionName );

        $this->params = $this->setParams( array_slice( $commandArray, 2 ) );
    }
    //}}}

    public function setController( $controllerName ) {

        $this->controller = $controllerName;

    }

    public function getController() {

        return $this->controller;

    }


    public function setAction( $actionName ) {

        $this->action = $actionName;

    }

    public function getAction( $actionName ) {

        return $this->action;

    }

    public function setParams( $params ) {

        $this->params = $params;

    }

    public function getParams( $params ) {

        return $this->params;

    }
}
?>
