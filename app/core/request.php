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
     * モデル用パラメータ格納
     */
    private $data = array();

    /**
     * コンストラクタ
     */
    public function __construct() {

        // URI解析処理
        $this->uri_interpret();

        // リクエストハンドラー
        $this->request_handler();

        // セッションハンドラー
        $this->session_handler();

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
        $controllerName = ( empty( $commandArray[0] ) ) ? 'root' : $commandArray[0];
        $this->setController( $controllerName );
       
        // アクション名をセット
        $actionName = ( empty($commandArray[1]) ) ? 'index' : $commandArray[1];
        $this->setAction( $actionName );

        $this->params = $this->setParams( array_slice( $commandArray, 2 ) );
    }
    //}}}


    /// {{{ request_handler
    /**
     * リクエストハンドラー
     */
    private function request_handler() {

        if( count($_GET) )     $this->params['get']     = $_GET;
        if( count($_POST) )    $this->params['post']    = $_POST;
        if( count($_REQUEST) ) $this->params['request'] = $__REQUEST;

        $this->model_item_handler( $_GET );
        $this->model_item_handler( $_POST );
    
    }
    // }}}


    // {{{ model_item_handler
    /**
     *
     */
    private function model_item_handler( $requests ) {

        foreach( $requests as $key => $request ) {

            if( strpos( $key, '/' ) !== FALSE ) {

                list( $model, $element ) = explode( '/', $reqeust );
                $this->data[$model][$element] = $request;
            }

        }

    }
    // }}}


    // {{{ session_handler
    /**
     *
     */
    private function session_handler() {




    }
    // }}}


    public function setController( $controllerName ) {

        $this->controller = $controllerName;

    }

    public function getController() {

        return $this->controller;

    }


    public function setAction( $actionName ) {

        $this->action = $actionName;

    }

    public function getAction() {

        return $this->action;

    }

    public function setParams( $params ) {

        $this->params = $params;

    }

    public function getParams() {

        return $this->params;

    }

    public function setData( $name, $value ) {

        $this->data[$name] = $value;

    }

    public function getData() {

        return $this->data;

    }


}
?>
