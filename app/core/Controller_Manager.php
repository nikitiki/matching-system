<?php
/**
 * 実行ファイル指定クラス
 */
class Controller_Manager
{
    /**
     * コントローラーファイル指定変数
     * 
     * @var mixed
     * @access private
     */
    private $controller = null;


    /**
     * POST または GETパラメータ格納変数
     *
     * @var mixed
     * @var private
     */
    private $params;


    /**
     * __construct
     */
    public function __construct() {

        $this->route();

    }


    /**
     * 実行ファイル指定処理
     *
     * @access private
     * @return 
     */
    private function route() {

        $path = $_SERVER['REQUEST_URI'];
        $requestURI = explode( '/', $_SERVER['REQUEST_URI'] );
        $scriptName = explode( '/', $_SERVER['SCRIPT_NAME'] );

        // 前者と後者の差異を比べて後者にないものを取得
        $commandArray = array_diff_assoc( $requestURI, $scriptName );

        // 配列を再配置
        $commandArray = array_values( $commandArray );

        // コントローラー
        
            $this->controller = $match[1];

        // 初期化
        $this->params = array();

        // パラメータ格納
        $idx = strpos( $path, '?' );
        
        // GETかPOSTか
        if( $idx !== false ) {

            // GETの場合
            $get = array();

            // ?以降を取得
            parse_str( substr( $path, $idx+1 ), $get );
            $this->params['post'] = $get;
        }

        if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

            $this->params['post'] = $_POST;

        }
    }


    /**
     * 実行コントローラー名取得
     *
     * @access public
     * @return string
     */
    public function getController() {
        return $this->controller;
    }


    /**
     * パラメータ取得
     *
     * @access public
     * @return array
     */
    public function getParams() {
        return $this->params;
    }

}
?>
