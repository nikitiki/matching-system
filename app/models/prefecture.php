<?php
/**
 * 都道府県モデル定義
 */
class Prefecture extends Model
{

    public function selectPre() {

        $sql = 'select * from prefecture where id = :id';

        $bind_params = array( ':id' => 2 );

        $res = $this->db->find( $sql, $this->con, $bind_params );

        return $res;
    }


/**
    public function find() {

        $sql = 'select * from prefecture';

        $res = $this->db->find( $sql, $this->con );

        return $res;

    }
**/
}
?>
