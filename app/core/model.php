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


    /**
     * $B%(%i!<%a%C%;!<%83JG<(B
     */
    public $error_msg;


    // {{{ construct
    /**
     * $B%3%s%9%H%i%/%?(B
     */
    public function __construct() {

        if( empty( $this->con ) ) {

            $database = TDatabase::singleton();

            $this->con = $database['con'];

            $this->db  = $database['db'];

        }
    }
    // }}}


    // {{{
    /**
     * $B%P%j%G!<%7%g%s%k!<%kDj5A(B
     */
    public function rules() {
        return false;
    }
    // }}}


    // {{{
    /**
     * $B%P%j%G!<%7%g%s<B9T(B
     */
    public function validate() {


        var_dump( $this->rules() );
    }
    // }}}
}
?>
