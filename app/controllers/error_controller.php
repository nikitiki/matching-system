<?php
class ErrorController extends Controller
{
    /**
     * index
     */
    public function index() {

        // @TODO 日本語メッセージ別ファイルに定義
        trigger_error( '指定したコントローラーがありません', E_USER_ERROR );

    }

}
?>
