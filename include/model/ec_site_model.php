<?php

//require_once '../../include/config/const.php';

$user_id;
$user_name;
$password;
$create_date;
$update_date;
$cart_id;
$order_id;
$product_id;
$product_qty;
$product_name;
$price;
$public_flg;
$image_id;
$image_name;
$stock_id;
$stock_qty;

/**
 * データベースへ接続
 * 
 * @return $db
 */
function connect_db() {
    $db = new PDO(DSN,LOGIN_USER,PASSWORD);
    return $db;
}

