<?php
/**
 *
 */
class Pager extends Util
{

    // {{{ getPager
    /*
     * @access public
     * @param array $options ページャの生成に必要な各種オプション値
     *                 total_count:
     *                 page:
     *                 perpage_count:
     *                 base_url:
     *                 pager_param_name
     *
     *  @return array ページャオブジェクト
     *      (   perv: 前ページへのリンク
     *          next: 次ページへのリンク
     *          current: 現ページへのリンク
     *          pager: ページオブジェクト
     *      )
     *      各リンク、ページオブジェクトは、page:ページ番号 (0〜) index:インデックス番号(1〜) link:リンク　という構成。
     *      prev, nextについては、前のページ、もしくは次のページが存在しなければNULLを設定する
     *
     */
/*
    function getPager( &$options ) {

        // 
        $direct_link_list = array();

        if( $options['total_count'] == 0 ) {
            return array();
        }

        // 
        $page = $options['page'];

        // リンクのペースURL設定
        $base_url = '';
        if( strlen( $options['base_url'] == 0 ) ) {
            $base_url = $this->getHostInfo() . $_SERVER['REDIRECT_URL'];
        } else {
            $base_url = $options['base_url'];
        }

        // リンクのパラメータ設定
        $params = '';
        foreach( $options['conditions'] as $key => $value ) {
        
            if( strlen( $params == 0 ) ) $params .= '?';

            $params .= "&$key=$value";
        }
        if( strlen( $params ) == 0 ) $params = '?';
        else $params .= '&';


        // ページパラメータ名の設定
        $pager_param_name = '';
        if( strlen( $options['pager_param_name'] ) == 0 ) {

            // 未定義の場合はpageを設定
            $pager_param_name = 'page';
        } else {
            $pager_param_name = $options['pager_param_name'];
        }

        // ページごとの表示件数
        $perpage_count = 0;
        if( $options['perpage_count'] == null ) {

            // 未定義の場合は10
            $perpage_count = 10;
        } else {
            $perpage_count = $options['perpage_count'];
        }

        // 総ページ数の計算
        $all_page = ceil( $options['total_count'] / $perpage_count );

        // 各ページごとに表示に必要なデータを生成する
        for( $i=1; $i<=$all_page; $i++ ) {

            // 初期化
            $ln = null;

            // リンクの設定（現在表示しているページについてはリンクを生成しない）
            if( $i != $page ) {
                $ln = $base_url . $params . "$pager_param_name=$i";
            }

            $direct_link_list[] = array(
                'page'  => $i,
                'link'  => $ln
            );
        }

        // 前ページデータの生成
        $prev = null;
        if( $page > 1 ) {

            $prev = array(
                'page'  => $page - 1,
                'link' => $base_url . $params . "$pager_param_name=" . ($page-1)
            );
        }

        // 次ページデータの生成
        $next = null;
        if( $page < $all_page -1 ) {

            $next = array(
                'page'  => $page + 1,
                'index' => $base_url . $params . "$pager_param_name=" . ($page + 1)
            );

        }

        // 現ページデータの生成
        $current = array(
            'page'  => $page,
            'link'  => $base_url . $params . "$pager_param_name=" . $page
        );

        return array(
            'prev' => $prev,
            'next' => $next,
            'current' => $current,
            'pager' => $direct_link_list,
            'total_cnt' => $options['total_count']
        );
    }

*/

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
