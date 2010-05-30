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
     * テーブル名
     */
    public $table_name;

    /**
     * エラーメッセージ格納
     */
    public $err_msg;


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
     *
     * @param data array 
     * @return boolean 
     */
    public function validate( $data_array = array() ) {

        $validate = new Validate();
        $rules = $this->rules();

        foreach( $data_array as $model_name => $model ) {

            foreach( $model as $column => $value ) {

                // バリデーション項目で定義されているか
                if( isset( $rules[$column] ) ) {

                    foreach( $rules[$column] as $rule_key => $rule_value ) {

                        // バリデート内で定義されているか
                        if( is_callable( array( $validate, $rule_key ) ) ) {
                            if( !$bool = $validate->$rule_key( $value, $rule_value ) ) {
                                // エラーメッセージ取得
                                $this->err_msg[$column][] = $validate->getErrMsg( $rule_key, $rules[$column]['name'] );
                            }
                        }

                        // ruleという項目が定義されているか
                        if( isset( $rule_key['rule'] ) && $rule_key == 'rule' ) {

                            // ルールが複数定義されているか
                            if( $is_conma = strpos( $rule_value, ',' ) ) { 
                            
                                // ,で分かれているルールを配列に直す
                                $rule_arr = explode( ',', $rule_value );
                            } else {
                                $rule_arr = array( $rule_value );
                            }

                            // 定義されている配列分ループ
                            foreach( $rule_arr as $rule ) {

                                // バリデーションクラスに指定したルールが定義されているか
                                if ( is_callable( array( $validate, $rule ) ) ) {
                                    if ( !$bool = $validate->$rule( $value ) ) {

                                        // エラーメッセージ取得
                                        $this->err_msg[$column][] = $validate->getErrMsg( $rule, $rules[$column]['name'] );
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return ( empty( $this->err_msg ) );
    }
    // }}}


    // {{{ describe
    /**
     * describe
     */
    public function describe() {

        // クエリ生成
        $query = "DESCRIBE $this->table_name";

        // 取得
        $res = $this->db->find( $query, $this->con );

        return $res;

    }
    // }}}

    // {{{ getColumn
    /**
     * テーブルのカラム名取得
     */
    public function getColumn() {

        $res = $this->describe();

        $ret = array();
        foreach( $res as $v ) {

            // フィールド名取得
            $ret[ $v['Field'] ] = null;
        }

        return $ret;
    }
    // }}}


    // {{{
    /**
     *
     */
    public function query( $query, $bind_params = null, $condition = null ) {

        $res = $this->db->find( $query, $this->con, $bind_params );

        return $res;
    }

    // {{{ find
    /**
     *
     */
    public function find( $bind_params = null, $condition = null ) {

        // クエリ生成
        $query = "SELECT * FROM $this->table_name ";

        // 条件句があれば追加
        if( !is_null( $condition ) ) {
            $query .= $condition;
        }

        $res = $this->db->find( $query, $this->con, $bind_params );

        return $res;
    }
    // }}}

    // {{{ insert
    /**
     * @return mixed sucess id / fail false
     */
    public function insert( $data ) {

        $formated_data = array();

        // テーブルに存在するカラムだけを抜き出す
        $formated_data = $this->getLogicColumn( $data );

        // インサート処理
        $this->db->insert( $formated_data, $this->con, $this->table_name );

        // インサートID取得
        if( !$res = $this->db->getLastInsertId( $this->con ) ) {
            $res = false;
        }

        return $res;
    }
    // }}}

    // {{{ update
    /**
     * 
     */
    public function update( $data, $cond, $bind_params ) {

        $formated_data = array();

        // テーブルに存在するカラムだけを抜き出
        $formated_data = $this->getLogicColumn( $data );

        // アップデート処理
        $res = $this->db->update( $formated_data, $this->con, $this->table_name, $cond, $bind_params );

        // エラーチェック
        if( !$res ) {
            $res = false;
        }
        return $res;
    }
    // }}}


    // {{{ getLogicColumn
    /**
     *
     */
    public function getLogicColumn( $data ) {

        // カラム名取得
        $columns = $this->getColumn();

        // $columns: ['カラム名'] => null
        foreach( $data[$this->table_name] as $field => $value ) { 

            // テーブルにあるカラムだけを抽出
            if( array_key_exists( $field, $columns ) ) { 
                $formated_data[$field] = $value;
            }   
        }
        return $formated_data;
    }
    // }}}

}
?>
