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
    public $params = array();

    /**
     * モデル用パラメータ格納
     */
    public $data = array();

    /**
     * コンストラクタ
     */
    public function __construct() {

        // URI解析処理
        $this->uri_interpret();

        // ノーマライズトハンドラー
        $this->normalize_handler();

        // モデル用リクエストハンドラー
        $this->model_item_handler( $_GET );

        // モデル用リクエストハンドラー
        $this->model_item_handler( $_POST );

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


    /// {{{ normalize_handler
    /**
     * ノーマライズハンドラー
     *
     * リクエストをノーマライズ。magic_quotes_gpcがonならば
     * クォートされた文字列を元に戻す
     */
    private function normalize_handler() {

        if( function_exists( 'get_magic_quotes_gpc' && get_magic_quotes_gpc() ) ) {

            if( isset( $_GET ) )
                $_GET     = $this->strip_slashes( $_GET );
            if( isset( $_POST ) )
                $_POST    = $this->strip_slashes( $_POST );
            if( isset( $_REQUEST ) )
                $_REQUEST = $this->strip_slashes( $_REQUEST );
            if( isset( $_COOKIE ) )
                $_COOKIE  = $this->strip_slashes( $_COOKIE );

        }

    }
    // }}}

    // {{{ strip_slashes
    /**
     * strip_slasheshes
     *
     * magic_quotes_gpcがonならばクォートされた文字列を元に戻す
     *
     */
    public function stripe_slashes( &$data ) {

        return is_array( $data ) ? array_map( array( $this, 'stripe_slashes' ), $data ) : stripslashes( $data );

    }
    // }}}


    // {{{ model_item_handler
    /**
     * モデル用リクエストハンドラー
     */
    private function model_item_handler( $requests ) {

        foreach( $requests as $key => $request ) {

            if( strpos( $key, '/' ) !== FALSE ) {

                list( $model, $element ) = explode( '/', $key );
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


    // {{{ getParam
    /**
     * GET または POST指定パラメータを取得
     * 指定したパラメータがなかったら第二引数で定義した値を取得
     *
     * @param string パラメータ名
     * @param mixed 指定パラメータがない場合の初期値
     * @return mixed GET or POST値
     */
    public function getParam( $name, $default = null ) {

        return isset( $_GET[ $name ] ) ? $_GET[ $name ] : ( isset( $_POST[ $name ] ) ? $_POST[ $name ] : $default );

    }
    // }}}


    // {{{ getQuery
    /**
     * GET値取得
     */
    public function getQuery( $name, $default = null ) {
        return isset( $_GET[ $name ] ) ? $_GET[ $name ] : $default;
    }
    // }}}

    // {{{ getPost
    /**
     * POST値取得
     */
    public function getPost( $name, $default = null ) {
        return isset( $_POST[ $name ] ) ? $_POST[ $name ] : $default;
    }
    // }}}


    // {{{ set
    /**
     * controllerで格納した変数をviewで利用
     */
    public function set( $name, $value ) {

        $this->params[ $name ] = $value;
    }

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
