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
} catch (PDOException $e){
    echo $e->getMessage();
    exit();
}

post_cart($db);

$links = [
    "商品一覧" => "catalog.php",
    "ログアウト" => "logout.php"
];
//$links = [];    //ヘッダ内リンクが無い場合

include ('../../include/view/ec_cart_view.php');

