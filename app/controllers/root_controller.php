<?php
class RootController extends AppController
{

    var $use = array( 'user' );

    //{{{ index
    /**
     * indexアクション
     */
    public function index() {

        $this->setTemplate( 'default' );

    }
    // }}}

}
?>
