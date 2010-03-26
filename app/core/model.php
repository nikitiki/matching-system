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

            foreach( $model as $column => $data ) {

                // バリデーション項目で定義されているか
                if( isset( $rules[$column] ) ) {

                    foreach( $rules[$column] as $rule_key => $rule_value ) {

                        // バリデート内で定義されているか
                        if( is_callable( array( $validate, $rule_key ) ) ) {
                            if( !$bool = $validate->$rule_key( $data, $rule_value ) ) {
                                // エラーメッセージ取得
                                $this->err_msg[$column][] = $validate->getErrMsg( $rule_key, $rules[$column]['name'] );
                            }
                        }

                        // ruleという項目が定義されているか
                        if( isset( $rule_key['rule'] ) 
                            && $rule_key == 'rule' 
                            && is_callable( array( $validate, $rule_value ) ) ) {
                            if ( !$bool = $validate->$rule_value( $data ) ) {

                                // エラーメッセージ取得
                                $this->err_msg[$column][] = $validate->getErrMsg( $rule_value, $rules[$column]['name'] );
                            }
                        }
                    }
                    // } foreach
                }
                // } if
            }
            // } foreach
        }
        // } foreach

        return ( empty( $this->err_msg ) );
    }
    // }}}
}
?>
