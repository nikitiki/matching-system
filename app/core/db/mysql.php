<?php
/**
 * MySQL�ڑ��N���X
 */
class Mysql {

    //{{{ connect
    /**
     * MySQL
     */
    public function connect( $config ) {

        $host = $config['host'];

        // �|�[�g�ݒ肪����΃Z�b�g
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