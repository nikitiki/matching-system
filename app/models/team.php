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
                       'required' => true,
                       'rule'     => 'alphanumeric',
                       'min'      => 5,
                       'max'      => 16
                   ),
                   'name'     => array(
                       'name'     => 'チーム名',
                       'required' => true,
                   ),
                   'email'    => array(
                       'name'     => 'Email',
                       'required' => true,
                       'rule'     => 'email',
                   ),
                   'pass'     => array(
                       'name'     => 'パスワード',
                       'required' => true,
                       'rule'     => 'alphanumeric',
                       'mix'      => 1,
                   ),
                   'pass-2'   => array(
                       'name'     => 'パスワード確認',
                       'required' => true,
                       'rule'     => 'alphanumeric',
                       'mix'      => 1
                   ) 
               );

    }
    // }}}

}
?>
