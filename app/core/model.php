<?php
/**
 *
 */
class Model
{

    /**
     * DB$B@\B3%*%V%8%'%/%H(B
     */
    public $con;

    /**
     * DB$B%*%V%8%'%/%H(B
     */
    public $db;

    function __construct() {

        if( empty( $this->con ) ) {

            $database = TDatabase::singleton();

            $this->con = $database['con'];

            $this->db  = $database['db'];

        }
    }

}
?>
