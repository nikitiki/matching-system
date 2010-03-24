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


    // {{{ construct
    /**
     * コンストラクタ
     */
    public function __construct() {

        if( empty( $this->con ) ) {

            $database = TDatabase::singleton();

            $this->con = $database['con'];

            $this->db  = $database['db'];

        }
    }
    // }}}


    // {{{
    /**
     * バリデーションルール定義
     */
    public function rules() {
        return false;
    }
    // }}}


    // {{{
    /**
     * バリデーション実行
     */
    public function validate() {


        var_dump( $this->rules() );
    }
    // }}}
}
?>
