<?php
require_once "db.php";

// define("HOST", "http://www.demaindeslaube.site/public");
define("HOST", "http://localhost/demaindeslaube/public");

// $db = new PDO("mysql:host=server770;dbname=u305945986_demaindeslaube", "u305945986_maxime", "traiteurMAX29.");
// $dsn = "mysql:host=server770;nomdb";
// $db = new PDO($dsn, "u305945986.Maxime", "traiteurMAX29.");
//;charset=utf8mb4

// DB
// DB
// define("DB_HOSTNAME", "localhost");
// define("DB_USERNAME", "u305945986_maxime");
// define("DB_PASSWORD", "jbTasQr;4");
// define("DB_DATABASE", "u305945986_demaindeslaube");
// define("DB_PORT", "65002");
define("DB_HOSTNAME", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "demaindeslaube");
define("DB_PORT", "3306");

$db = new DB(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
?>
