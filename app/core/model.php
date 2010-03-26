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

            foreach( $model as $column => $data ) {

                // $B%P%j%G!<%7%g%s9`L\$GDj5A$5$l$F$$$k$+(B
                if( isset( $rules[$column] ) ) {

                    foreach( $rules[$column] as $rule_key => $rule_value ) {

                        // $B%P%j%G!<%HFb$GDj5A$5$l$F$$$k$+(B
                        if( is_callable( array( $validate, $rule_key ) ) ) {
                            if( !$bool = $validate->$rule_key( $data, $rule_value ) ) {
                                // $B%(%i!<%a%C%;!<%8<hF@(B
                                $this->err_msg[$column][] = $validate->getErrMsg( $rule_key, $rules[$column]['name'] );
                            }
                        }

                        // rule$B$H$$$&9`L\$,Dj5A$5$l$F$$$k$+(B
                        if( isset( $rule_key['rule'] ) 
                            && $rule_key == 'rule' 
                            && is_callable( array( $validate, $rule_value ) ) ) {
                            if ( !$bool = $validate->$rule_value( $data ) ) {

                                // $B%(%i!<%a%C%;!<%8<hF@(B
                                $this->err_msg[$column][] = $validate->getErrMsg( $rule_value, $rules[$column]['name'] );
                            }
                        }
                    }
                    // } foreach
                }
                // } if
            }
            // } foreach
        }
        // } foreach

        return ( empty( $this->err_msg ) );
    }
    // }}}
}
?>
