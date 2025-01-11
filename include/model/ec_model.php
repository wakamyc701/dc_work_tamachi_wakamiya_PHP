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
$product_filename;
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
 * @return string
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
            //$_SESSION['err_msg']='登録されていないユーザー名です。';
            //echo '登録されていないユーザー名です。';
            $result_msg['err_msg'] = '登録されていないユーザー名です。';
            return $result_msg;
        } elseif (strcmp($result['user_password'], $user_password) != 0) {
            //$_SESSION['err_msg']='パスワードが異なります。';
            //echo 'パスワードが異なります。';
            $result_msg['err_msg'] = 'パスワードが異なります。';
            return $result_msg;
        } else {
            //$_SESSION['err_msg'] = '';
            $_SESSION['user_id'] = $result['user_id'];
            $_SESSION['user_name'] = $user_name;
            if ($result['user_id'] === '1') { //管理用ユーザーによるログイン
                //echo 'adminさん、ようこそ！';
                header('Location: manage.php'); //商品管理ページへ
                exit();
            } else {    //一般ユーザーによるログイン
                //echo 'ようこそ！<br>';
                //echo 'ID:' . $result["user_id"] . '<br>';
                //echo 'password:' . $result["user_password"];
                header('Location: catalog.php');    //商品一覧ページへ
                exit();
            }
        }
    }
}

/**
 * ユーザー登録
 * registration.phpにて使用
 * 
 * @param $db
 * @return string
 */
function user_registration($db) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_name = $_POST['user_name'];
        $user_password = $_POST['user_password'];

        if (!preg_match("/^\w{5,}$/", $user_name)) {    //ユーザー名のバリデーションチェック
            //$_SESSION['err_msg']='ユーザー名が不正です。';
            //echo 'ユーザー名が不正です。';
            $result_msg['err_msg'] = '登録できないユーザー名です。';
            return $result_msg;
        } elseif (!preg_match("/^\w{8,}$/", $user_password)) {  //パスワードのバリデーションチェック
            //$_SESSION['err_msg']='パスワードが不正です。';
            //echo 'パスワードが不正です。';
            $result_msg['err_msg'] = '登録できないパスワードです。';
            return $result_msg;
        } else {
            $sql = "INSERT INTO " .DB_USER. " (
                user_name,
                user_password,
                create_date,
                update_date
                ) VALUES (
                '$user_name',
                '$user_password',
                '".get_date()."',
                '".get_date()."'
                )";
            echo $sql;

            try {
                $stmt = $db->query($sql);
                //echo '<p class="suc_msg">ユーザー登録が完了しました。</p>';
                $result_msg['suc_msg'] = 'ユーザー登録が完了しました。';
                return $result_msg;
            } catch (PDOException $e){
                echo $e->getMessage();
                print_r($db->errorInfo());
                $errinfo = $db->errorInfo();
                if ($errinfo[1] == '1062') {
                    //$_SESSION['err_msg'] = '登録できないユーザー名です。';
                    $result_msg['err_msg'] = '登録できないユーザー名です。';
                    return $result_msg;
                } else {
                    //$_SESSION['err_msg'] = '申し訳ございません。再度お試しください。';
                    $result_msg['err_msg'] = '申し訳ございません。再度お試しください。';
                    return $result_msg;
                }
            }
        }
    }
}
