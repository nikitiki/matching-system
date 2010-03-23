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

        return $connect;

    }
    // }}}
    
    // {{{  query
    /**
     * query
     */
    public function query( $query, &$connect, $bind_params = array() ) {

        if( !empty( $bind_params ) ) {

            foreach( $bind_params as $key => $bind_param ) {

                // バインド変換
                $query = str_replace( 
                    $key
                    , mysql_escape_string( $bind_param )
                    , $query
                    );
            }
        }

        // クエリ実行
        $res = mysql_query( $query, $connect );

        // クエリ正常に動作したかチェック
        if( !$res ) {

            // @TODO
            trigger_error( 'クエリが正常に実行されませんでした', E_USER_ERROR );
        }

        return $res;
    }
    // }}}

    // {{{ find
    /**
     * find
     */
    public function find( $query, &$connect, $bind_params = array() ) {

        // 結果格納
        $ret = array();

        // 正常に実行できたかチェック
        if( $res = $this->query( $query, $connect, $bind_params ) ) {

            while( $row = mysql_fetch_assoc( $res ) ) {
                 array_push( $ret, $row );
            }
        }

        return $ret;

    }
}
?>
