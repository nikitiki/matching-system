<?php
/**
 * 
 */
class HtmlHelper extends AppHelper {


    // {{{ currentTag
    /**
     *
     */
    public function currentTag( $controller, $is_root = false ) {

       // ホスト部以外のURIを取得
       $uri = $_SERVER['REQUEST_URI'];

       // ?が出現する位置を取得
       $pos = strpos( $uri, '?' );

       // ？以降を削除
       if( $pos !== false ) {
           $uri = substr( $uri, 0, $pos );
       }

       // ルートかどうか
       if( $uri == '/' && $is_root ) return "current";

       // 指定したものかどうか
       if( preg_match( "/{$controller}/", $uri ) ) {
           return "current";
       }
    }
    // }}}

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

    // {{{ checkBox
    /**
     * 
     */
    public function checkBox( $elements, $checked = null ) {

        if( !is_array( $elements ) ) {
            return;
        }

        $name = ( isset( $elements['name'] ) ) ? "name='" . $elements['name'] . "'" : null;

        $id = ( isset( $elements['id'] ) ) ? "id='" . $elements['id'] . "'" : null;

        $tabindex = ( isset( $elements['tabindex'] ) ) ? "tabindex='" . $elements['tabindex'] . "'" : null;

        $value = ( isset( $elements['value'] ) ) ? "value='" . $elements['value'] . "'" : null;

        $checked = ( $value ) ? null : "checked";

        return "<input type='checkbox' {$name} {$id} {$tabindex} {$value} {$checked} >";
    }
    // }}}
}
?>
