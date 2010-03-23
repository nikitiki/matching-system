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

    function __construct() {

        if( empty( $this->con ) ) {

            $database = TDatabase::singleton();

            $this->con = $database['con'];

            $this->db  = $database['db'];

        }
    }

}
?>
