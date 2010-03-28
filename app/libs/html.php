<?php
/**
 * 
 */
class HtmlHelper extends AppHelper {


    // {{{ selectTag
    /**
     *
     */
    public function selectTag( $outputs, $name, $value = null ) {

        $html = "<select name=" . $name  . ">\n";

        foreach( $outputs as $option_value  => $output ) {

            // チェック定義
            if( $option_value == $value ) {

                $html .= "<option value='" . $option_value . "' selected='selected' >";

            } else {

                $html .= "<option value='" . $option_value . "' > "; 

            }

            $html .= $output . "</option>\n";

        }

        $html .= "</select>" ;

        return $html;

    }
    // }}}
}
?>
