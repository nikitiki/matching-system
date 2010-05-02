<?php
/**
 *
 */
class FormHelper extends HtmlHelper {


    // {{{ errors
    /**
     * 問題があったフィールドのエラーをすべて返す。
     */
    function errors( $error_msgs ) {

        if ( isset( $error_msgs ) && !empty( $error_msgs ) ) {

            echo "\t\t<div id=\"caution\">\n";
            echo "\t\t\t<p class=\"error\">\n";

            foreach( $error_msgs as $error_array ) {
                foreach( $error_array as $error_msg ) {

                    // エラー出力
                    echo $error_msg . "\n";
                    echo "<br />\n";
                }
            }
        }
        // /if
    }
    // }}}


    // {{{ select
    /**
     * 
     */
    public function select( $outputs, $name, $value = null, $attributes = array(), $showEmpty = null ) {

        $select = array();
        $tag    = null;
        $options = array();

        if( isset( $attributes ) && array_key_exists( 'multiple', $attributes ) ) {

            // マルチプル表示
            $tag = $this->tags['selectmultiplestart'];

        } else {

            // シングル表示
            $tag = $this->tags['selectstart'];

        }

        // セレクトはじめ部分options生成
        $options = $attributes;

        // セレクトはじめ部分生成
        $select[] = sprintf( $tag, $name, $this->_parseAttributes( $options ) );

        // 空のオプションを挟むかどうか
        if( $showEmpty != null ) {
            $select[] = sprintf( $this->tags['selectempty'], $options );
        }

        // オプション部分生成
        foreach( $outputs as $options_value => $options_string ) {

            $options = array();

            //  
            $options['selected'] =  ( $value == $options_value ) ? 'selected' : null; 

            // 
            $select[] = sprintf( $this->tags['selectoption'], 
                 $options_value,
                 $this->_parseAttributes( $options ),
                 $options_string
            );
        }

        // セレクトおわり部分生成
        $select[] = $this->tags['selectend'];

        // セレクトボックス構成各要素を\nで分割して文字列に変換
        return implode( "\n", $select );
    }


    // {{{ yearSelectTag
    /**
     * 年のセレクトボックスを出力
     * 今年から次の年までを出力
     */
    function yearSelectTag( $name, $value = null, $attributes = array(), $showEmpty = null ) {

        // 初期化
        $outputs = array();

        // 今年のYYYYを取得
        $year = (int)date( 'Y' );

        // 今年と来年の配列を作成
        for( $i=1; $i<=2; $i++ ) {

            $outputs[$year] = $year;
            $year++;
        }

        // htmlヘルパーでセレクトタグ生成
        return $this->select( $outputs, $name, $value, $attributes, $showEmpty );

    }
    // }}}


    // {{{ monthSelectTag
    /**
     * 
     */
    function monthSelectTag( $name, $value = null, $attributes = array(), $showEmpty = null ) {

        // 初期化
        $outputs = array();

        for( $i=1; $i<=12; $i++ ) {
            $outputs[$i] = $i;
        }

        // htmlヘルパーでセレクトタグ生成
        return $this->select( $outputs, $name, $value, $attributes, $showEmpty );
    }
    // }}}


    // {{{ timeSelectTag
    /**
     * cakephpほぼ引用
     */
    public function timeSelectTag( $type, $name, $value = null, $attributes = array(), $showEmpty = null ) {

        if( !isset( $type['name'] ) ) return '';

        $data = array();

        switch( $type['name'] ) {

            // 分
            case 'minute':
                if( isset( $type['intval'] ) ) {
                    $interval = $type['interval'];
                } else {
                    $interval = 1;
                }
                $i = 0;
                while( $i < 60 ) {
                    $data[$i] = sprintf( '%02d', $i );
                    $i += $interval;
                }
                break;

            // 時12
            case 'hour':
                for( $i=1; $i<=12; $i++ ) {
                    $data[sprintf( '%02d', $i )] = $i;
                }
                break;

            // 時24
            case 'hour24':
                for( $i = 0; $i <=23; $i++ ) {
                    $data[sprintf( '%02d', $i )] = $i;
                }
                break;

            // 日
            case 'day':
                $min = 1;
                $max = 31;

                if( isset( $type['min'] ) ) {
                    $min = $type['min'];
                }

                if( isset( $type['max'] ) ) {
                    $max = $type['max'];
                }

                for( $i=$min; $i<=$max; $i++ ) {
                    $data[sprintf( '%02d', $i )] = sprintf( '%02d', $i );
                }
                break;

             // 
             case 'month':
                 for( $m = 1; $m<=12; $m++ ) {
                     $data[sprintf( '%02d', $m )] = strftime( "%m", mktime( 1,1,1,$m,1,1999 ) );
                 }
                 break;

             // 
             case 'year':
                 $current = intval( date('Y') );

                 if( !isset( $type['min'] ) ) {
                     $min = $current - 10;
                 } else {
                     $min = $current - $type['min'];
                 }

                 if( !isset( $type['max'] ) ) {
                     $max = $current + 10;
                 } else {
                     $max = $current + $type['max'];
                 }

                 if( $min > $max ) {
                     list( $min, $max ) = array( $max, $min );
                 }

                 for( $i=$min; $i<=$max; $i++ ) {
                     $data[$i] = $i;
                 }
                 break;
        }

        return $this->select( $data, $name, $value, $attributes, $showEmpty );

    }
    // }}}

}
?>
