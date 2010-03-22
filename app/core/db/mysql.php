<?php
/**
 * MySQL接続クラス
 */
class Mysql {

    //{{{ connect
    /**
     * MySQL
     */
    public function connect( $config ) {

        $host = $config['host'];

        // ポート設定があればセット
        if( !empty( $config['port'] ) ) {

            $host .= ':' . $config['port'];
        }

        $connect = mysql_connect( $host, $config['user'], $config['pswd'] );

        if( $connect ) {

            mysql_select_db( $config['db_name'], $connect );

        }

    }

}
?>