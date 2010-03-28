<?php
class helper
{

    public $con_obj;

    public function __construct( &$con_obj ) {

        if( !$this->con_obj ) {
            $this->con_obj = $con_obj;
        }

    }

    public function startup() {}

}
?>
