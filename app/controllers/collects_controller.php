<?php
/**
 * 募集まわり
 */
class CollectsController extends AppController {

    // テンプレート設定
    var $layout = 'default';

    // モデル設定
    var $use = array( 'collect', 'prefecture' );

    // ヘルパー設定
    var $helper = array( 'form', 'prefecture' );

    // １ページに表示する件数
    const PERPAGE_CNT = 10;


    // {{{
    public function beforeFilter() {
        parent::beforeFilter();
    }
    // }}}

    // {{{ index
    /**
     * 募集一覧
     */
    public function index() {

        // 検索条件追加
        $where_query = '';
        $where_value = array();

        // 取得開始位置
        $curpage = ( $page = $this->request->getParam( 'page' ) ) ? $page : 1 ;

        // 取得数
        $count = $this->collect->query( 
            ' SELECT count(*) as count FROM collect JOIN team ' . 
            '  WHERE collect.team_id = team.id  ' . $where_query 
            , $where_value
        );

        // ページャー設定
        $pager = Pager::getPager( $count[0]['count'], $curpage, self::PERPAGE_CNT );

        // 募集一覧取得
        $collects = $this->collect->query(
            'SELECT collect.*, team.name ' .
            ' FROM collect ' .
            ' JOIN team  WHERE collect.team_id = team.id '. $where_query .
            ' limit ' . $pager['limit'] . ' offset ' . $pager['offset']
            , $where_value
        );      
 
        $this->request->set( 'pager',  $pager );

        // viewにセット
        $this->request->set( 'collects', $collects );

    }
    // }}}


    // {{{ add
    /**
     * 募集登録フォーム画面
     */
    public function add() {

        // カラム名取得 →テンプレート変数初期化
//        $this->request->set( 'data', $this->collect->getColumn() );
        $this->request->set( 'data', $this->collect->schema() );

    }
    // }}}


    // {{{ create
    /**
     * 募集登録処理
     */
    public function create() {


        // 送信ボタンで遷移していない場合登録画面に遷移させる
        if( empty( $this->request->data ) ) {
            $this->render( array( 'action' => 'add' ) );
            return;
        }

        // バリデーション実行
        if( !$res = $this->collect->validate( $this->request->data ) ) {

            // エラーメッセージセット
            $this->request->set( 'error_msgs', $this->collect->err_msg );

            // 入力値をセット
            $this->request->set( 'data', $this->request->data['collect'] );

            // 入力画面に戻る
            $this->render( array( 'action' => 'add' ) );

        } else {

            // 保存処理
            $this->collect->insert( $this->request->data );

            // 正常に処理終了したらリダイレクト
            $this->util->redirect( '/collects/index' );

        }

    }
    // }}}



}
?>
