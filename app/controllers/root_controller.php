<?php
class RootController extends AppController
{

    var $use = array( 'user' );

    //{{{ index
    /**
     * index
     */
    public function index() {

        $this->setTemplate( 'default' );
    }
    // }}}

}
?>
