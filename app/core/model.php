<?php
/**
 *
 */
class Model
{

    public $db;

    function __construct() {}

    // {{{ setDb
    /**
     * DB格納
     */
    function setDb( &$db ) {
        $this->db = $db;
    }

}
?>
