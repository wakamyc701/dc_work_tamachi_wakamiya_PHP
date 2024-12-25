<?php
session_start();

require_once '../../include/config/const.php';

require_once '../../include/model/ec_model.php';


try{
    $db = connect_db();
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    // echo 'データベース接続成功';
} catch (PDOException $e){
    echo $e->getMessage();
    exit();
}

include_once ('../../include/view/ec_index_view.php');
