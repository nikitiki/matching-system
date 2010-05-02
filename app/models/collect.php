<?php
/**
 * 募集モデル
 */
class Collect extends Model
{

    // {{{ rules
    /**
     * バリデーション項目定義
     */
    public function rules() {

        return array(
                    'time' => array( 
                        'name' => '時間帯',
                        'notEmpty' => true
                    ),
                    'locate' => array(
                        'name' => '場所',
                        'notEmpty' => true
                    )
        );
    }
    // }}}


    // {{{
    /**
     *
     */
    public function validate( $data = array() ) {

        parent::validate( $data );

        $year  = $data[$this->table_name]['year'];
        $month = $data[$this->table_name]['month'];
        $day   = $data[$this->table_name]['day'];

        if( !checkdate( (int)$month, (int)$day, (int)$year ) ) {
            $this->err_msg['day'][] = '有効な日付ではありません';
        }

        return ( empty( $this->err_msg ) );

    }
    // }}}


    // {{{ insert
    /**
     *
     */
    public function insert( $data ) {

        // day(日付)を生成
        $year  = $data[$this->table_name]['year'];
        $month = $data[$this->table_name]['month'];
        $day   = $data[$this->table_name]['day'];

        $data[$this->table_name]['day'] = $year . '-' . $month. '-' . $day;

        // sessionからteam_id取得 @TODO 
        $data[$this->table_name]['team_id'] = 1;

        $res = parent::insert( $data );

        return $res;
    }
    // }}}


    // {{{ update
    /**
     *
     */
    public function update( $data, $cond = null, $bind_params = null ) {


    }

    // {{{ schema
    /**
     *
     */
    public function schema() {

        // カラム取得
        $ret = parent::getColumn();

        // テーブルにないカラム追加
        $ret['year'] = null;
        $ret['month'] = null;

        return $ret;
    }
}
?>
