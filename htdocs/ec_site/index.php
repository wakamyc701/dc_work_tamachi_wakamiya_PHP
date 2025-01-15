<?php
session_start();

if (!empty($_SESSION['user_id'])) {
    header('Location: catalog.php');
    exit;
}

require_once '../../include/config/const.php';

require_once '../../include/model/ec_model.php';

clr_msg();

try{
    $db = connect_db();
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    // echo 'データベース接続成功';
    login_check($db);
} catch (PDOException $e){
    echo $e->getMessage();
    exit();
}

/* ヘッダ内のリンクは以下のように記述
$links = [
    "リンクA" => "index.php",
    "リンクB" => "index.php",
];*/
$links = [];    //ヘッダ内リンクが無い場合
$btn_title = 'ログインする';

include ('../../include/view/ec_index_view.php');

