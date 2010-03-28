<?php
/**
 * バリデーション定義クラス
 */
class Validate
{


    // {{{ not empty
    /**
     * Not Empty
     */
    public function notEmpty( $value, $chk_flg = false ) {

        if( $chk_flg == false ) {
            return true;
        }

        if( empty( $value ) && $value != '0' ) {
            return false;
        }

        return true;
    }
    // }}}


    // {{{ alphaNumeric
    /**
     * 小文字英数字チェック
     */
    public function alphaNumeric( $value ) {

        if( empty( $value ) && $value != '0' ) {
            return true;
        }

        $regex = '/^[a-zA-Z0-9]+$/';

        return $this->_check( $value, $regex );
    }
    // }}}


    // {{{ email
    /**
     * Emailフォーマットチェック
     */
    public function email( $value ) {

        if( empty( $value ) && $value != '0' ) { 
            return true;
        }

        $regex = '/^\\w+([-+.]\\w+)*@\\w+([-.]\\w+)*\\.\\w+([-.]\\w+)*$/';


        return $this->_check( $value, $regex );
    }
    // }}}


    // {{{ minLength
    /**
     * minLength
     */
    public function minLength( $value, $min ) {
        $length = strlen( $value );
        return ( $length >= $min );
    }
    // }}}


    // {{{ maxLenth
    /**
     * maxLenth
     */
    public function maxLength( $value, $max ) {
        $length = strlen( $value );
        return ( $length <= $max );
    }
    // }}}


    // {{{ check
    /**
     * Runs regular expression match
     *
     * @return boolean Success of match
     * @access protected
     */
    private function _check( $value, $regex ) {

        if( preg_match( $regex, $value ) ) {
            return true;    
        } else {
            return false;
        }
    }
    // }}}

    // {{{ getErrMsg
    /**
     * getErrMsg
     *
     * チェック項目から該当エラーメッセージを取得
     */
    public function getErrMsg( $key, $name ) {

        if( !array_key_exists( $key, $this->msg ) ) return;

        $msg = preg_replace( '%\{name\}%', $name, $this->msg[$key] );

        return $msg;

    }
    // }}}


    /**
     * エラーメッセージ
     */
    public $msg = array( 
        'notEmpty' => '{name}は必須入力です',
        'email'    => '{name}はメールアドレスの形式ではありません。',
        'alphanumeric' => '{name}は小文字の英数字で入力してください。', 
    );

}
?>
