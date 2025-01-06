<?php
session_start();

require_once '../../include/config/const.php';

require_once '../../include/model/ec_model.php';

$_SESSION['err_msg'] = '';


try{
    $db = connect_db();
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    // echo 'データベース接続成功';
    login_check($db);   //ここを別の関数にするのよ
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
$btn_title = 'ユーザー登録する';

include ('../../include/view/ec_user_registration_view.php');

