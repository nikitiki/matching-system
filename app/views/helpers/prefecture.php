<?php
/**
 * $BETF;I\8)$K4X$9$k%X%k%Q!<(B
 */
class PrefectureHelper extends AppHelper
{

    /**
     * $BETF;I\8)$N>pJs$r<hF@(B
     * [id] => 'name'$B$N7A$K@07A(B
     */
    public function getPrefectures() {

        // prefectureDB$B$+$iETF;I\8)<hF@(B
        $prefectures = $this->con_obj->prefecture->find();

        $res = array();

        // $B%G!<%?@07A(B
        foreach( $prefectures as  $prefecture ) {
            $res[$prefecture['id']] = $prefecture['name'];
        }

        return $res;

    }

}
?>
