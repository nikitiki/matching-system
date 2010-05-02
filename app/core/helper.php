<?php
/**
 * ヘルパー根幹処理
 */
class helper
{


    public $con_obj;

    public function __construct( &$con_obj ) { 

        if( !$this->con_obj ) { 
            $this->con_obj = $con_obj;
        }   

    }   

    public function startup() {}


    // {{{ _parseAttributes
    /**
     * cakeから移植
     * Then the value will be reset to be identical with key's name.
     * If the value is not one of these 3, the parameter is not output.
     *
     * @param  array  $options Array of options.
     * @param  array  $exclude Array of options to be excluded.
     * @param  string $insertBefore String to be inserted before options.
     * @param  string $insertAfter  String to be inserted ater options.
     * @return string
     */
    function _parseAttributes( $options, $exclude = null, $insertBefore = '', $insertAfter = null ) {

        if( is_array( $options ) ) {

            // optionsにescape => trueを追加
            $options = array_merge( array( 'escape' => true ), $options );

            if( !is_array( $exclude ) ) {
                $exclude = array();
            }

            // $optionsのkey値を取得。$optionsのkey値のうち、$excludeに含まれていない要素を取得
            $keys = array_diff( array_keys( $options ),
                // $excludeのvalue値にescapeを追加
                array_merge( (array)$exclude, array('escape') )
            );

            // 
            $values = array_intersect_key( array_values( $options ), $keys );

            $escape = $options['escape'];

            $attributes = array();

            //
            foreach( $keys as $index => $key ) {
                $attributes[] = $this->__formatAttribute( $key, $values[$index], $escape );
            }

            $out = implode('', $attributes);

        } else {
            $out = $options;
        }

        return $out ? $insertBefore . $out . $insertAfter : '';
    }
    // }}}


    // {{{ __formatAttribute
    /**
     * cakeのを移植
     * @param  string $key
     * @param  string $value
     * @return string
     * @access private
     */
    function __formatAttribute( $key, $value, $escape = true ) {

        $attribute = '';
        $attributeFormat = '%s="%s"';
        $minimizedAttributes = array( 'compact', 'checked', 'declare', 'readonly', 'disabled', 'selected', 'defer', 'ismap', 'nohref', 'noshade', 'nowrap', 'multiple', 'noresize');

        if( is_array( $value ) ) {
            $value = '';
        }

        if( in_array( $key, $minimizedAttributes ) ) {

            if( $value === 1 
                || $value === true
                || $value === 'true' 
                || $value == $key ) {

                $attribute = sprintf( $attributeFormat, $key, $key );
            }
        } else {

            $attribute = sprintf( $attributeFormat, $key, ( $escape ? h( $value ) : $value ) );
        }

        return $attribute;

    }
}
?>
