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
                   'pass'     => array(
                       'name'     => 'パスワード',
                       'notEmpty' => true,
                       'rule'     => 'alphanumeric',
                       'min'      => 1,
                       'max'      => 64
                   ),
                   'pass-2'   => array(
                       'name'     => 'パスワード確認',
                       'notEmpty' => true,
                       'rule'     => 'alphanumeric',
                       'min'      => 1,
                       'max'      => 5
                   ) 
               );

    }
    // }}}

}
?>
