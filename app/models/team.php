<?php
/**
 *
 */
class Team extends Model
{

    // {{{ rules
    /**
     * バリデーション項目定義
     */
    public function rules() {

        return array(
                   'login_id' => array(
                       'name'     => 'ログインID',
                       'notEmpty' => true,
                       'rule'     => 'alphanumeric',
                       'min'      => 5,
                       'max'      => 16
                   ),
                   'name'     => array(
                       'name'     => 'チーム名',
                       'notEmpty' => true,
                   ),
                   'email'    => array(
                       'name'     => 'Email',
                       'notEmpty' => true,
                       'rule'     => 'email',
                   ),
                   'password'     => array(
                       'name'     => 'パスワード',
                       'notEmpty' => true,
                       'rule'     => 'alphanumeric',
                       'min'      => 1,
                       'max'      => 64
                   ),
                   'password-2'   => array(
                       'name'     => 'パスワード確認',
                       'notEmpty' => true,
                       'rule'     => 'alphanumeric, equal',
                       'min'      => 1,
                       'max'      => 5
                   ),
               );

    }
    // }}}

    // {{{
    /**
     *
     */
    public function validate( $data_array = array() ) {

        parent::validate( $data_array );

        $pass = $data_array['team']['password'];
        $pass_2 = $data_array['team']['password-2'];

        // 入力したパスワードが一致していなかったらエラー
        if( !$res = $pass == $pass_2 ) {

             $this->err_msg['password-2'][] = 'パスワードとパスワード確認が一致しません';

        }

        return ( empty( $this->err_msg ) );

    }
    // }}}

    // {{{ insert
    /**
     *
     */
    public function insert( $data ) {

        // パスワードを暗号化
        $data[$this->table_name]['salt'] = 'aiueo';

        // インサート処理
        $res = parent::insert( $data );

        return $res;

    }
    // }}}

    // {{{
    /**
     * teamテーブルのカラム名取得
     */
    public function schema() {

        // カラム名取得
        $ret = parent::getColumn();

        // テーブルにないカラム名追加
        $ret['password-2'] = null;

        return $ret;
    }
    // }}}

}
?>
