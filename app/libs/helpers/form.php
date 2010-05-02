<?php
/**
 *
 */
class FormHelper extends HtmlHelper {


    // {{{ errors
    /**
     * $BLdBj$,$"$C$?%U%#!<%k%I$N%(%i!<$r$9$Y$FJV$9!#(B
     */
    function errors( $error_msgs ) {

        if ( isset( $error_msgs ) && !empty( $error_msgs ) ) {

            echo "\t\t<div id=\"caution\">\n";
            echo "\t\t\t<p class=\"error\">\n";

            foreach( $error_msgs as $error_array ) {
                foreach( $error_array as $error_msg ) {

                    // $B%(%i!<=PNO(B
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

            // $B%^%k%A%W%kI=<((B
            $tag = $this->tags['selectmultiplestart'];

        } else {

            // $B%7%s%0%kI=<((B
            $tag = $this->tags['selectstart'];

        }

        // $B%;%l%/%H$O$8$aItJ,(Boptions$B@8@.(B
        $options = $attributes;

        // $B%;%l%/%H$O$8$aItJ,@8@.(B
        $select[] = sprintf( $tag, $name, $this->_parseAttributes( $options ) );

        // $B6u$N%*%W%7%g%s$r64$`$+$I$&$+(B
        if( $showEmpty != null ) {
            $select[] = sprintf( $this->tags['selectempty'], $options );
        }

        // $B%*%W%7%g%sItJ,@8@.(B
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

        // $B%;%l%/%H$*$o$jItJ,@8@.(B
        $select[] = $this->tags['selectend'];

        // $B%;%l%/%H%\%C%/%99=@.3FMWAG$r(B\n$B$GJ,3d$7$FJ8;zNs$KJQ49(B
        return implode( "\n", $select );
    }


    // {{{ yearSelectTag
    /**
     * $BG/$N%;%l%/%H%\%C%/%9$r=PNO(B
     * $B:#G/$+$i<!$NG/$^$G$r=PNO(B
     */
    function yearSelectTag( $name, $value = null, $attributes = array(), $showEmpty = null ) {

        // $B=i4|2=(B
        $outputs = array();

        // $B:#G/$N(BYYYY$B$r<hF@(B
        $year = (int)date( 'Y' );

        // $B:#G/$HMhG/$NG[Ns$r:n@.(B
        for( $i=1; $i<=2; $i++ ) {

            $outputs[$year] = $year;
            $year++;
        }

        // html$B%X%k%Q!<$G%;%l%/%H%?%0@8@.(B
        return $this->select( $outputs, $name, $value, $attributes, $showEmpty );

    }
    // }}}


    // {{{ monthSelectTag
    /**
     * 
     */
    function monthSelectTag( $name, $value = null, $attributes = array(), $showEmpty = null ) {

        // $B=i4|2=(B
        $outputs = array();

        for( $i=1; $i<=12; $i++ ) {
            $outputs[$i] = $i;
        }

        // html$B%X%k%Q!<$G%;%l%/%H%?%0@8@.(B
        return $this->select( $outputs, $name, $value, $attributes, $showEmpty );
    }
    // }}}


    // {{{ timeSelectTag
    /**
     * cakephp$B$[$\0zMQ(B
     */
    public function timeSelectTag( $type, $name, $value = null, $attributes = array(), $showEmpty = null ) {

        if( !isset( $type['name'] ) ) return '';

        $data = array();

        switch( $type['name'] ) {

            // $BJ,(B
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

            // $B;~(B12
            case 'hour':
                for( $i=1; $i<=12; $i++ ) {
                    $data[sprintf( '%02d', $i )] = $i;
                }
                break;

            // $B;~(B24
            case 'hour24':
                for( $i = 0; $i <=23; $i++ ) {
                    $data[sprintf( '%02d', $i )] = $i;
                }
                break;

            // $BF|(B
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
