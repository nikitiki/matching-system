<?php
/**
 *
 */
class Pager extends Util
{

    // {{{ getPager
    /**
     *
     */
    static function getPager( $total_count = 0, $curpage = 1, $perpage = 20, $range = 5 ) {

        // 全ページ取得
        $total_pages = ceil( $total_count / $perpage );

        // 出力範囲設定
        $range = ( $total_pages < $range ) ? $total_pages : $range;

        // 出力範囲のはじめのページ取得
        if( $curpage >= ceil( $range / 2 ) ) {
            $start_page = $curpage - floor( $range / 2 );
        }
        $start_page = ( $start_page < 1 ) ? 1 : $start_page;

        // 出力範囲のさいごのページ取得
        $end_page = $start_page + $range - 1;
        if( $curpage > $total_pages - ceil( $range / 2 ) ) {
            $end_page = $total_pages;
            $start_page = $end_page - $range + 1;
        }

        // 前ページ
        if( $curpage > $start_page ) {
            $prev = $curpage - 1;
        } else {
            $prev = null;
        }

        // 次ページ
        if( $curpage < $end_page ) {
            $next = $curpage + 1;
        } else {
            $next = null;
        }

        // offset
        $offset = ceil( $curpage - 1 ) * $perpage;

        // limit
        $limit = ( $total_count < $perpage ) ? $total_count : $perpage;

        // はじめのページ
        $first_group = ceil( $curpage - ( $range - 1 ) / 2 ) > 1 ? 1 : null;

        // さいごのページ
        $last_group = $end_page < $total_pages ? $total_pages : null;

        return array(
                    'total_pages' => $total_pages,
                    'curpage'     => $curpage,
                    'range'       => $range,
                    'start_page'  => $start_page,
                    'end_page'    => $end_page,
                    'prev'        => $prev,
                    'next'        => $next,
                    'offset'      => $offset,
                    'limit'       => $limit,
                    'total_count' => $total_count,
                    'first_group' => $first_group,
                    'last_group'  => $last_group
                    );

    }
}
?>
