<?php
/**
 *
 */
class Model
{

    /**
     * DB接続オブジェクト
     */
    public $con;

    /**
     * DBオブジェクト
     */
    public $db;


    /**
     * エラーメッセージ格納
     */
    public $error_msg;

    function __construct() {

        if( empty( $this->con ) ) {

            $database = TDatabase::singleton();

            $this->con = $database['con'];

            $this->db  = $database['db'];

        }
    }

}
?>
