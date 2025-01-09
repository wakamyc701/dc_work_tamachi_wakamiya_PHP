<?php
session_start();

if ($_SESSION['user_id'] !== '1')  {
    header('Location: index.php');
    exit;
}

require_once '../../include/config/const.php';

require_once '../../include/model/ec_model.php';

$result_msg = [];

try{
    $db = connect_db();
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    // echo 'データベース接続成功';
    //$result_msg = なんか($db);
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

include ('../../include/view/ec_manage_view.php');

