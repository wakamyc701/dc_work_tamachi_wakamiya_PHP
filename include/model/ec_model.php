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
 * エラーメッセージを格納
 * 
 * @param string
 */
function err_msg ($msg) {
    $_SESSION['err_msg'] = $msg;
    $_SESSION['suc_msg'] = '';
}

/**
 * 成功メッセージを格納
 * 
 * @param string
 */
function suc_msg ($msg) {
    $_SESSION['err_msg'] = '';
    $_SESSION['suc_msg'] = $msg;
}

/**
 * エラー・成功メッセージをクリア
 */
function clr_msg () {
    $_SESSION['err_msg'] = '';
    $_SESSION['suc_msg'] = '';
}

/**
 * 値が0以上の整数であることの確認
 * 
 * @param int
 * @return int
 */
function check_int_0($num) {
    if (preg_match("/^[0-9]+$/", $num)) {
        return 1;
    } else {
        return 0;
    }
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
            err_msg('登録されていないユーザー名です。');
        } elseif (strcmp($result['user_password'], $user_password) != 0) {
            err_msg('パスワードが異なります。');
        } else {
            $_SESSION['user_id'] = $result['user_id'];
            $_SESSION['user_name'] = $user_name;
            if ($result['user_id'] === '1') { //管理用ユーザーによるログイン
                header('Location: manage.php'); //商品管理ページへ
                exit();
            } else {    //一般ユーザーによるログイン
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
            err_msg('登録できないユーザー名です。');
        } elseif (!preg_match("/^\w{8,}$/", $user_password)) {  //パスワードのバリデーションチェック
            err_msg('登録できないパスワードです。');
        } else {
            $sql = "INSERT INTO " .DB_USER. " (user_name, user_password, create_date, update_date) 
            VALUES ('$user_name', '$user_password', '".get_date()."', '".get_date()."' )";

            try {
                $stmt = $db->query($sql);
                suc_msg('ユーザー登録が完了しました。');
            } catch (PDOException $e){
                //echo $e->getMessage();
                //print_r($db->errorInfo());
                $errinfo = $db->errorInfo();
                if ($errinfo[1] == '1062') {
                    err_msg('登録できないユーザー名です。');
                } else {
                    err_msg('申し訳ございません。再度お試しください。');
                }
            }
        }
    }
}

/**
 * 商品管理ページからのPOSTが行われた場合の処理の振り分け
 * manage.phpにて使用
 * 
 * @return array
 */
function post_manage($db) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['post_form'] === 'registration'){
            product_registration($db);
        } elseif ($_POST['post_form'] === 'change_stock_qty') {
            change_stock_qty($db);
        } elseif ($_POST['post_form'] === 'change_public_flg') {
            change_public_flg($db);
        } elseif ($_POST['post_form'] === 'del_product') {
            del_product($db);
        }
    }
}

/**
 * 商品の登録
 * manage.phpにて使用
 * 
 * @param object $db
 */
function product_registration ($db) {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $stock_qty = $_POST['stock_qty'];
    $upload_image = $_FILES['upload_image'];
    $public_fig = $_POST['public_fig'];

    if ((!isset($product_name)) or ($product_name == "")) {
        err_msg('商品名が入力されていません');
    } elseif (!check_int_0($price)) {
        err_msg('価格を0以上の整数にしてください');
    } elseif (!check_int_0($stock_qty)) {
        err_msg('在庫数を0以上の整数にしてください');
    } elseif ($upload_image['size'] == 0) { //ファイルが送信されていない
        err_msg('ファイルが選択されていません');
    } elseif (($upload_image['type'] != 'image/jpeg') && ($upload_image['type'] != 'image/png')){   //ファイル形式が異なる
        err_msg('ファイルの形式が「JPEG」「PNG」でありません');
    } elseif (!isset($public_fig)) {
        err_msg('公開フラグが選択されていません');
    } else {
        product_registration_sql($db);
    }
}

/**
 * 商品登録のSQL実行部分
 * manage.phpにて使用
 * 
 * @param object $db
 */
function product_registration_sql ($db){
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $stock_qty = $_POST['stock_qty'];
    $upload_image = $_FILES['upload_image'];
    $public_fig = $_POST['public_fig'];

    $db->beginTransaction();   //トランザクション開始

    //ec_productへのinsert
    $sql_product = "INSERT INTO " .DB_PRODUCT. " (product_name, price, public_flg, create_date, update_date) 
    VALUES ('$product_name', '$price', '$public_fig', '".get_date()."', '".get_date()."' )";
    try {
        $stmt = $db->query($sql_product);
    } catch (PDOException $e){
        $db->rollback();
        err_msg('商品登録できませんでした。再度お試しください。');
        return;
    }

    //ec_productに登録した商品のproduct_id取得
    $sql_getid = "SELECT product_id FROM ".DB_PRODUCT." WHERE product_name = '$product_name' LIMIT 1";
    $stmt = $db->query($sql_getid);
    $result = $stmt->fetch();
    $product_id = $result['product_id'];

    //ec_stockへのinsert
    $sql_stock = "INSERT INTO " .DB_STOCK. " (product_id, stock_qty, create_date, update_date) 
    VALUES ('$product_id', '$stock_qty', '".get_date()."', '".get_date()."' )";
    try {
        $stmt = $db->query($sql_stock);
    } catch (PDOException $e){
        $db->rollback();
        err_msg('在庫数登録できませんでした。再度お試しください。');
        return;
    }

    //ファイル名の決定
    if ($upload_image['type'] == 'image/jpeg') {
        $image_name = 'product' . $product_id . '.jpg';
    } elseif ($upload_image['type'] == 'image/png') {
        $image_name = 'product' . $product_id . ".png";
    }

    //ec_imageへのinsert
    $sql_image = "INSERT INTO " .DB_IMAGE. " (product_id, image_name, create_date, update_date) 
    VALUES ('$product_id', '$image_name', '".get_date()."', '".get_date()."' )";
    try {
        $stmt = $db->query($sql_image);
    } catch (PDOException $e){
        $db->rollback();
        err_msg('画像登録できませんでした。再度お試しください。');
        return;
    }

    //画像のアップロード
    $save = '../ec_site/img/' . $image_name;

    if(move_uploaded_file($upload_image['tmp_name'],$save)){
        $db->commit();  //アップロード成功
        suc_msg('商品登録完了しました');
    } else {
        $db->rollback();    //アップロード失敗なのでロールバック
        err_msg('画像アップロードに失敗しました');
    }
}

/**
 * 管理画面の商品リスト作成
 * manage.phpにて使用
 * 
 * @param object $db
 */
function get_list_manage ($db) {
    $sql = "SELECT ec_product.product_id, ec_product.product_name, ec_product.price, ec_product.public_flg, ec_image.image_name, ec_stock.stock_qty 
    FROM " . DB_PRODUCT . " LEFT JOIN " . DB_IMAGE . " USING(product_id) LEFT JOIN " . DB_STOCK . " USING(product_id) ORDER BY product_id";
    $stmt = $db->query($sql);

    foreach($stmt as $row) {
        echo '<form method="post">
            <input type="hidden" name="product_id" value="' .$row['product_id'] . '">
            <tr class="list_bg' . $row['public_flg'] . '">
                <td><a href="../ec_site/img/' . $row['image_name'] . '" target="_blank"><img src="../ec_site/img/' . $row['image_name'] . '"></a></td>
                <td>' . $row['product_name'] . '</td>
                <td>' . $row['price'] . '</td>
                <td><input type="text" class="input_value" name="stock_qty" value="' .$row['stock_qty'] . '">
                <button name="post_form" value="change_stock_qty">在庫数変更</button></td>';
                if ($row['public_flg'] == 1) {
                    echo '<td><input type="hidden" name="next_flg" value="0">
                    <button name="post_form" value="change_public_flg">非公開にする</button></td>';
                } else {
                    echo '<td><input type="hidden" name="next_flg" value="1">
                    <button name="post_form" value="change_public_flg">公開にする</button></td>';
                }
                echo '<td><button name="post_form" value="del_product">削除する</button></td>
            </tr>
        </form>';
    }
}

/**
 * 商品在庫数の変更
 * manage.phpにて使用
 * 
 * @param object $db
 */
function change_stock_qty ($db) {
    if (!check_int_0($_POST['stock_qty'])) {
        err_msg('在庫数を0以上の整数にしてください');
        return;
    }
    $sql = "UPDATE " . DB_STOCK . " SET stock_qty = " . $_POST['stock_qty'] . ", update_date = '" . get_date() . "' 
    WHERE product_id = " . $_POST['product_id'] . "";
    try {
        $stmt = $db->query($sql);
        suc_msg('在庫数を変更しました');
    } catch (PDOException $e) {
        err_msg('在庫数を変更できませんでした。再度お試しください。');
    }
}

/**
 * 公開フラグの変更
 * manage.phpにて使用
 * 
 * @param object $db
 */
function change_public_flg ($db) {
    $sql = "UPDATE " . DB_PRODUCT . " SET public_flg = " . $_POST['next_flg'] . ", update_date = '" . get_date() . "' 
    WHERE product_id = " . $_POST['product_id'] . "";
    try {
        $stmt = $db->query($sql);
        suc_msg('公開フラグを変更しました');
    } catch (PDOException $e) {
        err_msg('公開フラグを変更できませんでした。再度お試しください。');
    }

}

/**
 * 商品の削除
 * manage.phpにて使用
 * 
 * @param object $db
 */
function del_product ($db) {
    $sql_product = "DELETE FROM " . DB_PRODUCT . " WHERE product_id = " . $_POST['product_id'] . "";
    $sql_image = "DELETE FROM " . DB_IMAGE . " WHERE product_id = " . $_POST['product_id'] . "";
    $sql_stock = "DELETE FROM " . DB_STOCK . " WHERE product_id = " . $_POST['product_id'] . "";

    $db->beginTransaction();
    try {
        $stmt_stock = $db->query($sql_stock);
        $stmt_image = $db->query($sql_image);
        $stmt_product = $db->query($sql_product);
        $db->commit();
        suc_msg('商品を削除しました');
    } catch (PDOException $e){
        $db->rollback();
        err_msg('商品を削除できませんでした');
    }
}

/**
 * 商品一覧画面の商品リスト作成
 * catalog.phpにて使用
 * 
 * @param object $db
 */
function get_list_catalog($db) {
    $sql = "SELECT ec_product.product_id, ec_product.product_name, ec_product.price, ec_product.public_flg, ec_image.image_name, ec_stock.stock_qty 
    FROM " . DB_PRODUCT . " LEFT JOIN " . DB_IMAGE . " USING(product_id) LEFT JOIN " . DB_STOCK . " USING(product_id) WHERE public_flg = 1 ORDER BY product_id";
    //echo('<p>'.$sql.'</p>');
    $stmt = $db->query($sql);

    echo '<form method="post"><div class="catalog_container">';
    foreach($stmt as $row) {
        echo '<div class="catalog_element">
            <a href="../ec_site/img/' . $row["image_name"] . '" target="_blank"><img src="../ec_site/img/' . $row["image_name"] . '"></a>
            <h3>' . $row["product_name"] . '</h3>
            <p>' . $row["price"] . '円</p>
            <button name="select_product_id" value="' . $row['product_id'] . '">カートに入れる</button>
            </div>';
    }
    echo '</div></form>';
}

function post_catalog ($db) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        suc_msg($_POST['select_product_id']);
    }
}