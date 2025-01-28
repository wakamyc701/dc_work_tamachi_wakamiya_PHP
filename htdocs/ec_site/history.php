<?php
session_start();

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require_once '../../include/config/const.php';

require_once '../../include/model/ec_model.php';

if ($_SESSION['page_now'] != 'history') {
    clr_msg();
    $_SESSION['page_now'] = 'history';
}

if ($_SESSION['purchased']) {   //購入完了後に遷移した場合はカートを破棄
    unset($_SESSION['cart_id']);
    unset($_SESSION['purchased']);
}

try{
    $db = connect_db();
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    echo $e->getMessage();
    exit();
}

$links = [
    "商品一覧" => "catalog.php",
    "カート" => "cart.php",
    "ログアウト" => "logout.php"
];
//$links = [];    //ヘッダ内リンクが無い場合

include ('../../include/view/ec_history_view.php');

