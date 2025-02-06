<?php
session_start();

if (!empty($_SESSION['user_id'])) {
    header('Location: catalog.php');
    exit;
}

require_once '../../include/config/const.php';

require_once '../../include/model/ec_model.php';

if ($_SESSION['page_now'] != 'index') {
    clr_msg();
    $_SESSION['page_now'] = 'index';
}

try{
    $db = connect_db();
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    // echo 'データベース接続成功';
    login_check($db);
} catch (PDOException $e){
    echo $e->getMessage();
    exit();
}

$links = [];
$btn_title = 'ログインする';

include ('../../include/view/ec_index_view.php');

