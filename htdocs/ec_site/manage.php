<?php
session_start();

if ($_SESSION['user_id'] !== '1')  {
    header('Location: index.php');
    exit;
}

require_once '../../include/config/const.php';

require_once '../../include/model/ec_model.php';

clr_msg();

try{
    $db = connect_db();
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    // echo 'データベース接続成功';
    //$result_msg = なんか($db);
} catch (PDOException $e){
    echo $e->getMessage();
    exit();
}

post_manage($db);

$links = [
    "ログアウト" => "logout.php"
];
//$links = [];    //ヘッダ内リンクが無い場合

include ('../../include/view/ec_manage_view.php');

