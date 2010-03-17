<?php
/**
 * 実行ファイル指定クラス
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

        // 実行コントローラー名取得
        $controller = $this->request_obj->getController() . '_controller';

        // 実行コントローラーまでのパス取得
        $controller_path = APP_CONTROLLERS_PATH . ucfirst( $controller ) . '.php';

        // 実行コントローラー存在チェック
        if( file_exists( $controller_path ) === false ) {
            $controller_path = APP_CONTROLLERS_PATH . 'error_controller.php';
        }

        // 実行コントローラー読み込み
        include_once( $controller_path );

        // インスタンス生成
        $this->con_obj = new $controller . ( $this->request_obj );
        
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

        // 指定アクション名取得
        $action = $this->request_obj->getAction();

        // 
        if( empty( $action ) ) {

            $action = 'index';

        } elseif( !is_callable( array( &$this->con_obj, $action ) ) ) {

            $action = 'error';

        }

        $this->con_obj->$action();

    }

    /**
     * アクション実行後処理
     */
    public function afterFilter() {
        $this->con_obj->afterFilter();
    }


    /**
     * 実行コントローラー名取得
     *
     * @access public
     * @return string
     */
    public function getCon_obj() {
        return $this->con_obj;
    }

}
?>
