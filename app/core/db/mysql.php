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

                // �o�C���h�ϊ�
                $query = str_replace( 
                    $key
                    , mysql_escape_string( $bind_param )
                    , $query
                    );
            }
        }

        // �N�G�����s
        $res = mysql_query( $query, $connect );

        // �N�G������ɓ��삵�����`�F�b�N
        if( !$res ) {

            // @TODO
            trigger_error( '�N�G��������Ɏ��s����܂���ł���', E_USER_ERROR );
        }

        return $res;
    }
    // }}}

    // {{{ find
    /**
     * find
     */
    public function find( $query, &$connect, $bind_params = array() ) {

        // ���ʊi�[
        $ret = array();

        // ����Ɏ��s�ł������`�F�b�N
        if( $res = $this->query( $query, $connect, $bind_params ) ) {

            while( $row = mysql_fetch_assoc( $res ) ) {
                 array_push( $ret, $row );
            }
        }

        return $ret;

    }
}
?>
