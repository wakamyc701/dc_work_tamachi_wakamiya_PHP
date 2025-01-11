<?php
session_start();

echo 'ログアウト中です';
$_SESSION = array();

header('Location: index.php');
exit();