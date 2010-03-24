<?php

define( 'BASE_PATH',   dirname(__FILE__) . '/../../' );
define( 'APP_PATH',    BASE_PATH . 'app/' );
define( 'PUBLIC_PATH', BASE_PATH . 'public/' );

define( 'APP_CORE_PATH',         APP_PATH. 'core/' );
define( 'APP_CONTROLLERS_PATH',  APP_PATH. 'controllers/' );
define( 'APP_MODELS_PATH',       APP_PATH. 'models/' );
define( 'APP_VIEWS_PATH',        APP_PATH. 'views/' );
define( 'APP_LIBS_PATH',         APP_PATH. 'libs/' );
define( 'APP_VIEWS_LAYOUT_PATH', APP_VIEWS_PATH. 'layout/' );
define( 'APP_DB_PATH',           APP_CORE_PATH. 'db/' );

// フレームワーク関連のファイルを読み込む
$_APP_REQUIRES = array(
     APP_CORE_PATH        . 'config.php',
     APP_CORE_PATH        . 'database.php',
     APP_CORE_PATH        . 'request.php',
     APP_CORE_PATH        . 'controller.php',
     APP_CORE_PATH        . 'dispatch.php',
     APP_CORE_PATH        . 'controller_manager.php',
     APP_CORE_PATH        . 'view_manager.php',
     APP_CORE_PATH        . 'model.php',
     APP_CORE_PATH        . 'util.php',
     APP_LIBS_PATH        . 'app_util.php',
     APP_LIBS_PATH        . 'validate.php',
     APP_CONTROLLERS_PATH . 'app_controller.php',
);

foreach( $_APP_REQUIRES as $_APP_REQUIRE ) {

    if( is_readable( $_APP_REQUIRE ) && is_file( $_APP_REQUIRE ) ) {
        require_once( $_APP_REQUIRE );
    } else {
        echo '<pre>' . $_APP_REQUIRE . '</pre>';
    }

}

?>
