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
     * $B%F!<%V%kL>(B
     */
    public $table_name;

    /**
     * $B%(%i!<%a%C%;!<%83JG<(B
     */
    public $err_msg;


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
     *
     * @param data array 
     * @return boolean 
     */
    public function validate( $data_array = array() ) {

        $validate = new Validate();
        $rules = $this->rules();

        foreach( $data_array as $model_name => $model ) {

            foreach( $model as $column => $value ) {

                // $B%P%j%G!<%7%g%s9`L\$GDj5A$5$l$F$$$k$+(B
                if( isset( $rules[$column] ) ) {

                    foreach( $rules[$column] as $rule_key => $rule_value ) {

                        // $B%P%j%G!<%HFb$GDj5A$5$l$F$$$k$+(B
                        if( is_callable( array( $validate, $rule_key ) ) ) {
                            if( !$bool = $validate->$rule_key( $value, $rule_value ) ) {
                                // $B%(%i!<%a%C%;!<%8<hF@(B
                                $this->err_msg[$column][] = $validate->getErrMsg( $rule_key, $rules[$column]['name'] );
                            }
                        }

                        // rule$B$H$$$&9`L\$,Dj5A$5$l$F$$$k$+(B
                        if( isset( $rule_key['rule'] ) && $rule_key == 'rule' ) {

                            // $B%k!<%k$,J#?tDj5A$5$l$F$$$k$+(B
                            if( $is_conma = strpos( $rule_value, ',' ) ) { 
                            
                                // ,$B$GJ,$+$l$F$$$k%k!<%k$rG[Ns$KD>$9(B
                                $rule_arr = explode( ',', $rule_value );
                            } else {
                                $rule_arr = array( $rule_value );
                            }

                            // $BDj5A$5$l$F$$$kG[NsJ,%k!<%W(B
                            foreach( $rule_arr as $rule ) {

                                // $B%P%j%G!<%7%g%s%/%i%9$K;XDj$7$?%k!<%k$,Dj5A$5$l$F$$$k$+(B
                                if ( is_callable( array( $validate, $rule ) ) ) {
                                    if ( !$bool = $validate->$rule( $value ) ) {

                                        // $B%(%i!<%a%C%;!<%8<hF@(B
                                        $this->err_msg[$column][] = $validate->getErrMsg( $rule, $rules[$column]['name'] );
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return ( empty( $this->err_msg ) );
    }
    // }}}


    // {{{ describe
    /**
     * describe
     */
    public function describe() {

        // $B%/%(%j@8@.(B
        $query = "DESCRIBE $this->table_name";

        // $B<hF@(B
        $res = $this->db->find( $query, $this->con );

        return $res;

    }
    // }}}

    // {{{ getColumn
    /**
     * $B%F!<%V%k$N%+%i%`L><hF@(B
     */
    public function getColumn() {

        $res = $this->describe();

        $ret = array();
        foreach( $res as $v ) {

            // $B%U%#!<%k%IL><hF@(B
            $ret[ $v['Field'] ] = null;
        }

        return $ret;
    }
    // }}}


    // {{{
    /**
     *
     */
    public function query( $query, $bind_params = null, $condition = null ) {

        $res = $this->db->find( $query, $this->con, $bind_params );

        return $res;
    }

    // {{{ find
    /**
     *
     */
    public function find( $bind_params = null, $condition = null ) {

        // $B%/%(%j@8@.(B
        $query = "SELECT * FROM $this->table_name ";

        // $B>r7o6g$,$"$l$PDI2C(B
        if( !is_null( $condition ) ) {
            $query .= $condition;
        }

        $res = $this->db->find( $query, $this->con, $bind_params );

        return $res;
    }
    // }}}

    // {{{ insert
    /**
     * @return mixed sucess id / fail false
     */
    public function insert( $data ) {

        $formated_data = array();

        // $B%F!<%V%k$KB8:_$9$k%+%i%`$@$1$rH4$-=P$9(B
        $formated_data = $this->getLogicColumn( $data );

        // $B%$%s%5!<%H=hM}(B
        $this->db->insert( $formated_data, $this->con, $this->table_name );

        // $B%$%s%5!<%H(BID$B<hF@(B
        if( !$res = $this->db->getLastInsertId( $this->con ) ) {
            $res = false;
        }

        return $res;
    }
    // }}}

    // {{{ update
    /**
     * 
     */
    public function update( $data, $cond, $bind_params ) {

        $formated_data = array();

        // $B%F!<%V%k$KB8:_$9$k%+%i%`$@$1$rH4$-=P(B
        $formated_data = $this->getLogicColumn( $data );

        // $B%"%C%W%G!<%H=hM}(B
        $res = $this->db->update( $formated_data, $this->con, $this->table_name, $cond, $bind_params );

        // $B%(%i!<%A%'%C%/(B
        if( !$res ) {
            $res = false;
        }
        return $res;
    }
    // }}}


    // {{{ getLogicColumn
    /**
     *
     */
    public function getLogicColumn( $data ) {

        // $B%+%i%`L><hF@(B
        $columns = $this->getColumn();

        // $columns: ['$B%+%i%`L>(B'] => null
        foreach( $data[$this->table_name] as $field => $value ) { 

            // $B%F!<%V%k$K$"$k%+%i%`$@$1$rCj=P(B
            if( array_key_exists( $field, $columns ) ) { 
                $formated_data[$field] = $value;
            }   
        }
        return $formated_data;
    }
    // }}}

}
?>
