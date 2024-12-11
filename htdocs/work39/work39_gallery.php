<?php
require_once '../../include/model/work39_model.php';

try{
    $db = connect_db();
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    check_post($db);

} catch (PDOException $e){
    echo $e->getMessage();
    exit();
}

//    $db->close();

$current_page = 'gallery';
include_once '../../include/view/work39_view.php';
