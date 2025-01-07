<?php

$user_id;
$user_name;
$user_password;
$create_date;
$update_date;
$cart_id;
$order_id;
$product_id;
$product_qty;
$product_name;
$price;
$public_flg;
$image_id;
$image_name;
$stock_id;
$stock_qty;

/**
 * データベースへ接続
 * 
 * @return $db
 */
function connect_db() {
    $db = new PDO(DSN,LOGIN_USER,PASSWORD);
    return $db;
}

/**
 * htmlspecialchars（特殊文字の変換）のラッパー関数
 *
 * @param string 
 * @return string 
 */
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * 日付の取得
 * 
 * @return string
 */
function get_date(){
    $date = date("Y-m-d");
    return $date;
}

/**
 * ログインフォームの内容をデータベースと照合し、ページ遷移
 * index.phpにて使用
 * 
 * @param $db
 */
function login_check($db){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_name = h($_POST['user_name']);
        $user_password = h($_POST['user_password']);

        $sql = "SELECT user_id, user_password FROM ".DB_USER." WHERE user_name = '$user_name' LIMIT 1";
        $stmt = $db->query($sql);
        $result = $stmt->fetch();
        //var_dump($result);
        if ($result == false) {
            $_SESSION['err_msg']='登録されていないユーザー名です。';
            echo '登録されていないユーザー名です。';
        } elseif (strcmp($result['user_password'], $user_password) != 0) {
            $_SESSION['err_msg']='パスワードが異なります。';
            echo 'パスワードが異なります。';
        } else {
            $_SESSION['err_msg'] = '';
            $_SESSION['user_id'] = $result['user_id'];
            if ($result['user_id'] === '1') { //管理用ユーザーによるログイン
                echo 'adminさん、ようこそ！';
                //商品管理ページへ
            } else {    //一般ユーザーによるログイン
                echo 'ようこそ！<br>';
                echo 'ID:' . $result["user_id"] . '<br>';
                echo 'password:' . $result["user_password"];
                //商品一覧ページへ
            }
        }
    }
}

/**
 * ユーザー登録
 * registration.phpにて使用
 * 
 * @param $db
 */
function user_registration($db) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_name = $_POST['user_name'];
        $user_password = $_POST['user_password'];

        if (!preg_match("/^\w{5,}$/", $user_name)) {    //ユーザー名のバリデーションチェック
            $_SESSION['err_msg']='ユーザー名が不正です。';
            echo 'ユーザー名が不正です。';
        } elseif (!preg_match("/^\w{8,}$/", $user_password)) {  //パスワードのバリデーションチェック
            $_SESSION['err_msg']='パスワードが不正です。';
            echo 'パスワードが不正です。';
        } else {
            $sql = "INSERT INTO " .DB_USER. " (
                user_name,
                user_password,
                create_date,
                update,date
                ) VALUES (
                '$user_name',
                '$user_password',
                '".get_date()."',
                '".get_date()."'
                )";
            echo $sql;
        }
    }
}
