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

        // IDとパスワードの組み合わせがユニークか
        if( $res =  $this->find( array( ':login_id' => $data_array['team']['login_id'] ), 'WHERE login_id = :login_id' ) ) {

            $this->err_msg['login_id'][] = ( 'すでにそのIDは使われています' );
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
        $data[$this->table_name]['salt'] = MD5( time() );

        $data[$this->table_name]['password'] = crypt( $data[$this->table_name]['password'], $data[$this->table_name]['salt'] );

        $data[$this->table_name]['code'] = crypt( time() );

        // インサート処理
        $res = parent::insert( $data );

        return $res;

    }
    // }}}

    // {{{
    /**
     *
     */
    public function sendVerificationEmail( $id = null, $url ) {

        if( is_null( $id ) || empty( $id ) ) {
            trigger_error( '通信ができなくなりました', E_USER_ERROR );
        }

        // インサートデータ取得
        $data = $this->find( array( ':id' => $id ), 'WHERE id = :id' );

        // saltとlogin_idのハッシュで確認させる
        $login_id_hash = MD5( $data[0]['login_id'] );
        $code = $data[0]['code'];

        // メールエンコーディング
        mb_language("ja");

        // 送り先
        $to = $data[0]['email'];

        // 件名 @TODO
        $subject = "[none name] 仮登録のお知らせ";
        $subject = mb_convert_encoding( $subject, 'ISO-2022-JP', 'UTF-8' );
        $subject = mb_encode_mimeheader( $subject, 'ISO-2022-JP' );

        // 登録完了URL
        $verify_url = $url . "/team/verifyAccount?code=$code&l=$login_id_hash";

        // ヘッダー設定
        $headers = <<<MESSAGE
From: none name <tatemori@growthsquare.co.jp>
Content-Type: text/plain;charaset=ISO-2022-JP
Contetn-Transfer-Encoding: 7bit
MESSAGE;

        // 本文
        $msg = <<<EMAIL
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【none name】仮登録のお知らせ
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

この度は、none name (http://www.tweet-mail.jp/) に
ご登録いただきまして、ありがとうございます。

下記のURLをクリックすることでツイートメールへの登録が完了いたします。

■『登録完了』はこちら
$verify_url

※URLが2行に渡った場合はコピーしてブラウザのアドレスバーにはりつけてください。


このメールの受信に心当たりのない場合は、手続きを行っていただく必要
はありません。
今後お客様にメールが送信されることはございません。

EMAIL;

        return mail( $to, $subject, $msg, $headers );

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
