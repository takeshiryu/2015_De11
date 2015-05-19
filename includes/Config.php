<?php

ob_start();
session_start();

define("PASSWORD", "");
define("USERNAME", "root");
define("DATABASE", "wd_ass");
define("SERVER", "localhost:3306");

define("TABLE_USER", "User");
define("TABLE_BILL", "Bill");
define("TABLE_PRODUCT", "Product");
define("TABLE_CATEGORY", "Category");
define("TABLE_BILL_PRODUCT", "bill_products");
define("TABLE_CATEGORY_PRODUCT", "category_products");
global $conn;
try {
    $conn = new PDO("mysql:host=" . SERVER . ";dbname=" . DATABASE, USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
// set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//echo "Connect successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

function __autoload($_class) {
    $class = strtolower($_class);

    // Load models
    $classpath = './Models/' . $class . '.php';
    if (file_exists($classpath)) {
        require_once $classpath;
    }
}
