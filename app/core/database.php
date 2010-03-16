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

        if( !is_null( DB_HOST_TT) && 
            !is_null( DB_USER_TT ) && 
            !is_null( DB_PSWD_TT ) && 
            !is_null( DB_KIND_TT ) && 
            !is_null( DB_NAME_TT )
        ) {

            // DB接続
            $inctance = new PDO( DB_KIND_TT. ':' . DB_NAME_TT
                    , DB_USER_TT
                    , DB_PSWD_TT
                );
            // エラー設定
            $inctance->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

            self::$db = $inctance;
        }

        return self::$db;
    }
}
?>
