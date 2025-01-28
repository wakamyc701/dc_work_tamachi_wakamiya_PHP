<?php
session_start();

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require_once '../../include/config/const.php';

require_once '../../include/model/ec_model.php';

if ($_SESSION['page_now'] != 'catalog') {
    clr_msg();
    $_SESSION['page_now'] = 'catalog';
}

if ($_SESSION['purchased']) {   //購入完了後に遷移した場合はカートを破棄
    unset($_SESSION['cart_id']);
    unset($_SESSION['purchased']);
}

try{
    $db = connect_db();
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    // echo 'データベース接続成功';
    //$result_msg = なんか($db);
} catch (PDOException $e){
    echo $e->getMessage();
    exit();
}

post_catalog($db);

$links = [
    "カート" => "cart.php",
    "購入履歴" => "history.php",
    "ログアウト" => "logout.php"
];
//$links = [];    //ヘッダ内リンクが無い場合

include ('../../include/view/ec_catalog_view.php');

