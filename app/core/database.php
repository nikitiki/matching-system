<?php
/**
 * DB接続クラス
 */
class TDatabase 
{

    // DBオブジェクト
    static $db;

    /**
     * コンストラクタ
     */
    function __construct() {
    }

    /**
     *
     *
     */
    public static function singleton() {

        if( !is_null( DB_HOST_TT ) && 
            !is_null( DB_USER_TT ) && 
            !is_null( DB_PSWD_TT ) && 
            !is_null( DB_KIND_TT ) && 
            !is_null( DB_NAME_TT )
        ) {

            if( !self::$db ) {

                // 該当DB接続ファイル読み込み
                include_once( APP_DB_PATH . DB_KIND_TT . '.php' );

                // DBクラス名取得
                $db_kind = ucfirst( DB_KIND_TT );

                // DBインスタンス生成
                $db = &new $db_kind();

                // 初期化
                $config = array();
                $config['host']    = DB_HOST_TT;
                $config['user']    = DB_USER_TT;
                $config['pswd']    = DB_PSWD_TT;
                $config['db_name'] = DB_NAME_TT;
                $config['port']    = DB_PORT_TT;

                // DB接続処理
                $db->connect( $config );

            }
        }

        return self::$db;
    }
}
?>
