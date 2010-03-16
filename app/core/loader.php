<?php

define( 'BASE_PATH',   dirname(__FILE__) . '/../../' );
define( 'APP_PATH',    BASE_PATH . 'app/' );
define( 'PUBLIC_PATH', BASE_PATH . 'public/' );

define( 'APP_CORE_PATH',        APP_PATH. 'core/' );
define( 'APP_CONTROLLERS_PATH', APP_PATH. 'controllers/' );
define( 'APP_MODELS_PATH',      APP_PATH. 'models/' );
define( 'APP_VIEWS_PATH',       APP_PATH. 'views/' );

// フレームワーク関連のファイルを読み込む
$_APP_REQUIRES = array(
     APP_CORE_PATH        . 'config.php',
     APP_CORE_PATH        . 'database.php',
     APP_CORE_PATH        . 'dispatch.php',
     APP_CORE_PATH        . 'Controller_Manager.php',
     APP_CONTROLLERS_PATH . 'app_conroller.php',
     APP_VIEWS_PATH       . 'app_view.php',
);

foreach( $_APP_REQUIRES as $_APP_REQUIRE ) {

    if( is_readable( $_APP_REQUIRE ) && is_file( $_APP_REQUIRE ) ) {
        require_once( $_APP_REQUIRE );
    } else {
        echo '<pre>' . $_APP_REQUIRE . '</pre>';
    }

}

?>
