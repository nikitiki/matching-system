<?php
/**
 * userモデル定義
 */
class User extends Model
{

    public function selectPre() {

        $sql = 'select * from prefecture where id = :id';

        $bind_params = array( ':id' => 2 );

        $res = $this->db->find( $sql, $this->con, $bind_params );

        return $res;
    }
}
?>
