<?php
/**
 * 指定ファイル実行クラス
 */
class Controller_Manager
{

    /**
     *  リクエストオブジェクト
     *
     * @var obj 
     * @access private
     */
    private $request_obj = null;

    /**
     * コントローラーオブジェクト
     * 
     * @var mixed
     * @access private
     */
    private $con_obj = null;


    /**
     * 実行コントローラー名格納
     */
    private $controller_name;


    /**
     * 実行アクション名格納
     */
    private $action_name;


    /**
     * __construct
     */
    public function __construct( &$request = null ) {

        $this->request_obj = $request;

    }


    /**
     * 実行ファイル指定処理
     *
     * @access private
     * @return 
     */
    public function dispatch() {

        // 実行ファイル
        $controller = $this->request_obj->getController();

        // 実行コントローラーファイル取得
        $controller_file = $controller . '_controller.php';

        // 実行コントローラーまでのパス取得
        $controller_path = APP_CONTROLLERS_PATH . $controller_file;

        // 実行コントローラー存在チェック
        if( file_exists( $controller_path ) == false ) {
            $controller = 'error';
            $controller_path = APP_CONTROLLERS_PATH . 'error_controller.php';
        }

        // 実行コントローラー名格納
        $this->controller_name = $controller;

        // 実行コントローラー読み込み
        include_once( $controller_path );

        // クラス名にフォーマット
        $controller_class = ucfirst( $controller ) . 'Controller';

        // インスタンス生成
        $this->con_obj = new $controller_class( $this );

        // 指定アクション名取得
        $action = $this->request_obj->getAction();

        // アクション名存在チェック
        if( empty( $action ) ) {

            $action = 'index';

        } elseif( !is_callable( array( &$this->con_obj, $action ) ) ) {

            $action = 'error';

        }

        // 実行アクション名格納
        $this->action_name = $action;

        // 初期処理実行
        $this->con_obj->startup();
    }


    /**
     * アクション実行前処理
     */
    public function beforeFilter() {
        $this->con_obj->beforeFilter();
    }


    /**
     * アクション実行
     */
    public function execute() {

        // 実行アクション名格納
        $action =  $this->action_name;

        // 指定アクション実行
        $this->con_obj->$action();

    }

    /**
     * アクション実行後処理
     */
    public function afterFilter() {
        $this->con_obj->afterFilter();
    }


    /**
     * 実行コントローラーオブジェクト取得
     *
     * @access public
     * @return object
     */
    public function getCon_obj() {
        return $this->con_obj;
    }

    /**
     * リクエストオブジェクト取得
     *
     * @access public
     * @return object
     */
    public function getRequest_obj() {
        return $this->request_obj;
    }


    /**
     * 実行コントローラー名取得
     *
     * @access public
     * @return string
     */
    public function getControllerName() {

        return $this->controller_name;

    }


    /**
     * 実行アクション名取得
     *
     * @access public
     * @return string
     */
    public function getActionName() {

       return  $this->action_name;

    }

}
?>
