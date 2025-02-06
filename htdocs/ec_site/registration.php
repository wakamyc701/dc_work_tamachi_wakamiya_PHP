<?php
session_start();

if (!empty($_SESSION['user_id'])) {
    header('Location: catalog.php');
    exit;
}

require_once '../../include/config/const.php';

require_once '../../include/model/ec_model.php';

if ($_SESSION['page_now'] != 'registration') {
    clr_msg();
    $_SESSION['page_now'] = 'registration';
}

try{
    $db = connect_db();
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    // echo 'データベース接続成功';
} catch (PDOException $e){
    echo $e->getMessage();
    exit();
}
user_registration($db);

$links = [];
$btn_title = 'ユーザー登録する';

include ('../../include/view/ec_registration_view.php');

