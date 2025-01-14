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
 * @return object $db
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
 * @param object $db
 * @return array
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
 * @param object $db
 * @return array
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
            $sql = "INSERT INTO " .DB_USER. " (user_name, user_password, create_date, update_date) 
                VALUES ('$user_name', '$user_password', '".get_date()."', '".get_date()."' )";
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

/**
 * 商品管理ページからのPOSTが行われた場合の処理の振り分け
 * @return array
 */
function post_manage() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['post_form'] === 'registration'){
            $result_msg = product_registration();
            return $result_msg;
        } elseif ($_POST['post_form'] === 'change_stock') {
            $result_msg = change_stock();
            return $result_msg;
        }
    }
}

/**
 * 商品の登録
 * @return array
 */
function product_registration () {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $stock_qty = $_POST['stock_qty'];
    $upload_image = $_POST['upload_image'];
    $public_fig = $_POST['public_fig'];

    if ((!isset($product_name)) or ($product_name == "")) {
        $result_msg['err_msg'] = '商品名が入力されていません';
        return $result_msg;
    }

    if (!preg_match("/^[0-9]+$/", $price)) {
        $result_msg['err_msg'] = '価格を0以上の整数にしてください';
        return $result_msg;
    }

    if (!preg_match("/^[0-9]+$/", $stock_qty)) {
        $result_msg['err_msg'] = '在庫数を0以上の整数にしてください';
        return $result_msg;
    }

    if ($_FILES['upload_image']['size'] == 0) { //ファイルが送信されていない
        $result_msg['err_msg'] = 'ファイルが送信されていません';
        return $result_msg;
    }
    
    if (($_FILES['upload_image']['type'] != 'image/jpeg') && ($_FILES['upload_image']['type'] != 'image/png')){   //ファイル形式が異なる
        $result_msg['err_msg'] = 'ファイルの形式が「JPEG」「PNG」でありません';
        return $result_msg;
    }

    if (!isset($public_fig)) {
        $result_msg['err_msg'] = '公開フラグが入力されていません';
        return $result_msg;
    }

    $result_msg['suc_msg'] = '商品登録（仮）';
    return $result_msg;
}

/**
 * 商品在庫数の変更
 * @return array
 */
function change_stock () {
    $result_msg['suc_msg'] = '在庫数変更（仮）';
    return $result_msg;
}

/**
 * 商品管理画面用のSELECT実行
 * 
 * @param object $db
 * @return array
 */
