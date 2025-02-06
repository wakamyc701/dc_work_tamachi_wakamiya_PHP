<?php
session_start();

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require_once '../../include/config/const.php';

require_once '../../include/model/ec_model.php';

if ($_SESSION['page_now'] != 'cart') {
    clr_msg();
    $_SESSION['page_now'] = 'cart';
}

try{
    $db = connect_db();
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    // echo 'データベース接続成功';
} catch (PDOException $e){
    echo $e->getMessage();
    exit();
}

post_cart($db);

$links = [
    "商品一覧" => "catalog.php",
    "購入履歴" => "history.php",
    "ログアウト" => "logout.php"
];

include ('../../include/view/ec_cart_view.php');

