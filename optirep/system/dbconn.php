
<?php

    //////////////////////////////////////////////////////////////////
    // DEFINE DATABASE CONNECTION
    //////////////////////////////////////////////////////////////////
    if(!defined('DB_HOST')){ define("DB_HOST", "localhost"); };
    if(!defined('DB_NAME')){ define("DB_NAME", "martine_opti-dev"); }; // martine_opti
    if(!defined('DB_USER')){ define("DB_USER", "martine_opti"); }; // martine_opti
    if(!defined('DB_PASS')){ define("DB_PASS", "gpcq9XeM"); }; // gpcq9XeM

    $conn = @mysql_connect(DB_HOST, DB_USER, DB_PASS);
    @mysql_select_db(DB_NAME, $conn);
    mysql_set_charset('utf8',$conn);

?>
