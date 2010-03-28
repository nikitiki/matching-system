<?php
/**
 * 都道府県に関するヘルパー
 */
class PrefectureHelper extends AppHelper
{

    /**
     * 都道府県の情報を取得
     * [id] => 'name'の形に整形
     */
    public function getPrefectures() {

        // prefectureDBから都道府県取得
        $prefectures = $this->con_obj->prefecture->find();

        $res = array();

        // データ整形
        foreach( $prefectures as  $prefecture ) {
            $res[$prefecture['id']] = $prefecture['name'];
        }

        return $res;

    }

}
?>
