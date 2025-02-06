<?php
session_start();

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require_once '../../include/config/const.php';

require_once '../../include/model/ec_model.php';

if ($_SESSION['page_now'] != 'thankyou') {
    clr_msg();
    $_SESSION['page_now'] = 'thankyou';
}

try{
    $db = connect_db();
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    // echo 'データベース接続成功';
} catch (PDOException $e){
    echo $e->getMessage();
    exit();
}

$links = [
    "商品一覧" => "catalog.php",
    "購入履歴" => "history.php",
    "ログアウト" => "logout.php"
];

include ('../../include/view/ec_thankyou_view.php');

