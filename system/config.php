<?php
require_once "db.php";

define("HOST", "http://localhost/demain-des-laube");

// DB
define("DB_HOSTNAME", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "demaindeslaube");
define("DB_PORT", "3306");

$db = new DB(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
?>