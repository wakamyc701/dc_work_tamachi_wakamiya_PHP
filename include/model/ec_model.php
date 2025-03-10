<?php

$user_id;
$user_name;
$user_password;
$create_date;
$update_date;
$cart_id;
$price_sum;
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
    $db = new PDO(DSN, LOGIN_USER, PASSWORD);
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
function err_msg($msg) {
    $_SESSION['err_msg'] = $msg;
    $_SESSION['suc_msg'] = '';
}

/**
 * 成功メッセージを格納
 * 
 * @param string
 */
function suc_msg($msg) {
    $_SESSION['err_msg'] = '';
    $_SESSION['suc_msg'] = $msg;
}

/**
 * エラー・成功メッセージをクリア
 */
function clr_msg() {
    $_SESSION['err_msg'] = '';
    $_SESSION['suc_msg'] = '';
}

/**
 * 値が0以上の整数であることの確認
 * 
 * @param int
 * @return int 1もしくは0
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

        if (validate_name($user_name) === 0) return;
        if (validate_pwd($user_password) === 0) return;

        $sql = "SELECT user_id, user_password FROM " . DB_USER . " 
        WHERE user_name = :user_name LIMIT 1";
        $stmt = $db->prepare($sql);

        $stmt -> bindValue(':user_name', $user_name);

        $stmt->execute();
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
 */
function user_registration($db) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_name = $_POST['user_name'];
        $user_password = $_POST['user_password'];

        if (validate_name($user_name) === 0) return;
        if (validate_pwd($user_password) === 0) return;

        $sql = "INSERT INTO " .DB_USER. " (user_name, user_password, create_date, update_date) 
        VALUES (:user_name, :user_password, '" . get_date() . "', '" . get_date() . "' )";

        try {
            $stmt = $db->prepare($sql);

            $stmt -> bindValue(':user_name', $user_name);
            $stmt -> bindValue(':user_password', $user_password);

            $stmt->execute();
            suc_msg('ユーザー登録が完了しました。');
            header('Location: ./registration.php');
            exit();
        } catch (PDOException $e){
            $errinfo = $db->errorInfo();
            if ($errinfo[1] == '1062') {    //既に存在するユーザー名と重複
                err_msg('登録できないユーザー名です。');
            } else {
                err_msg('申し訳ございません。再度お試しください。');
            }
        }
    }
}

/**
 * 商品管理ページからのPOSTが行われた場合の処理の振り分け
 * manage.phpにて使用
 * 
 * @param object $db
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
function product_registration($db) {
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
function product_registration_sql($db){
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $stock_qty = $_POST['stock_qty'];
    $upload_image = $_FILES['upload_image'];
    $public_fig = $_POST['public_fig'];

    $db->beginTransaction();   //トランザクション開始

    //ec_productへのinsert
    $sql_product = "INSERT INTO " . DB_PRODUCT . " (product_name, price, public_flg, create_date, update_date) 
    VALUES ('" . $product_name . "', '" . $price. "', '" . $public_fig. "', '" . get_date() . "', '" . get_date() . "' )";
    try {
        $stmt = $db->query($sql_product);
    } catch (PDOException $e){
        $db->rollback();
        err_msg('商品登録できませんでした。再度お試しください。');
        return;
    }

    //ec_productに登録した商品のproduct_id取得
    $sql_getid = "SELECT LAST_INSERT_ID()";
    $stmt =  $db->query($sql_getid);
    $result = $stmt->fetch();
    $product_id = $result['LAST_INSERT_ID()'];

    //ec_stockへのinsert
    $sql_stock = "INSERT INTO " .DB_STOCK. " (product_id, stock_qty, create_date, update_date) 
    VALUES ('" . $product_id . "', '" . $stock_qty . "', '" . get_date() . "', '" . get_date() . "' )";
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
    VALUES ('" . $product_id . "', '" . $image_name . "', '" . get_date() . "', '" . get_date() . "' )";
    try {
        $stmt = $db->query($sql_image);
    } catch (PDOException $e){
        $db->rollback();
        err_msg('画像登録できませんでした。再度お試しください。');
        return;
    }

    //画像のアップロード
    $save = '../ec_site/img/' . $image_name;

    if(move_uploaded_file($upload_image['tmp_name'], $save)){
        $db->commit();  //アップロード成功
        suc_msg('商品登録完了しました');
        header('Location: ./manage.php');
        exit();
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
function get_list_manage($db) {
    $sql = "SELECT " . DB_PRODUCT . ".product_id, " . DB_PRODUCT . ".product_name, " . DB_PRODUCT . ".price, " 
    . DB_PRODUCT . ".public_flg, " . DB_PRODUCT . ".handle_flg, " . DB_IMAGE . ".image_name, " . DB_STOCK . ".stock_qty 
    FROM " . DB_PRODUCT . " LEFT JOIN " . DB_IMAGE . " USING(product_id) LEFT JOIN " . DB_STOCK . " USING(product_id) 
    WHERE handle_flg = 1 ORDER BY product_id";
    $stmt = $db->query($sql);

    foreach($stmt as $row) {
        echo '<form method="post">
            <input type="hidden" name="product_id" value="' .$row['product_id'] . '">
            <tr class="list_bg' . $row['public_flg'] . '">
                <td><a href="../ec_site/img/' . $row['image_name'] . '" target="_blank">
                <img src="../ec_site/img/' . $row['image_name'] . '"></a></td>
                <td>' . $row['product_name'] . '</td>
                <td>' . $row['price'] . '</td>
                <td><input type="number" class="input_value change_stock_form" name="stock_qty" 
                value="' .$row['stock_qty'] . '" min="0">
                <button class="change_stock_btn" name="post_form" value="change_stock_qty">在庫数変更</button>
                <p class="red_text small_text change_stock_check_msg"></p></td>';
                if ($row['public_flg'] == 1) {
                    echo '<td><input type="hidden" name="next_flg" value="0">
                    <button name="post_form" value="change_public_flg">非公開にする</button></td>';
                } elseif ($row['public_flg'] == 0) {
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
function change_stock_qty($db) {
    $product_id = $_POST['product_id'];
    $stock_qty_next = $_POST['stock_qty'];

    if (!check_int_0($stock_qty_next)) {
        err_msg('在庫数を0以上の整数にしてください');
        return;
    }
    $sql = "UPDATE " . DB_STOCK . " SET stock_qty = " . $stock_qty_next . ", update_date = '" . get_date() . "' 
    WHERE product_id = " . $product_id . "";
    $stmt = $db->query($sql);
    if ($stmt) {
        suc_msg('在庫数を変更しました');
        header('Location: ./manage.php');
        exit();
    } else {
        err_msg('在庫数を変更できませんでした。再度お試しください。');
    }
}

/**
 * 公開フラグの変更
 * manage.phpにて使用
 * 
 * @param object $db
 */
function change_public_flg($db) {
    $product_id = $_POST['product_id'];
    $next_flg = $_POST['next_flg'];

    $sql = "UPDATE " . DB_PRODUCT . " SET public_flg = " . $next_flg . ", update_date = '" . get_date() . "' 
    WHERE product_id = " . $product_id . "";
    $stmt = $db->query($sql);
    if ($stmt) {
        suc_msg('公開フラグを変更しました');
        header('Location: ./manage.php');
        exit();
    } else {
        err_msg('公開フラグを変更できませんでした。再度お試しください。');
    }
}

/**
 * 商品の削除
 * manage.phpにて使用
 * 
 * @param object $db
 */
function del_product($db) {
    /* DBから削除する場合の処理
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
        header('Location: ./manage.php');
        exit();
    } catch (PDOException $e){
        $db->rollback();
        err_msg('商品を削除できませんでした');
    }
    */
    $product_id = $_POST['product_id'];

    $sql = "UPDATE " . DB_PRODUCT . " SET public_flg = 0, handle_flg = 0, update_date = '" . get_date() . "' 
    WHERE product_id = " . $product_id . "";
    $stmt = $db->query($sql);
    if ($stmt) {
        suc_msg('商品を削除しました');
        header('Location: ./manage.php');
        exit();
    } else {
        err_msg('商品を削除できませんでした。再度お試しください。');
    }
}

/**
 * 商品一覧画面の商品リスト作成
 * catalog.phpにて使用
 * 
 * @param object $db
 */
function get_list_catalog($db) {
    $sql = "SELECT " . DB_PRODUCT . ".product_id, " . DB_PRODUCT . ".product_name, " . DB_PRODUCT . ".price, " 
    . DB_PRODUCT . ".public_flg, " . DB_IMAGE . ".image_name, " . DB_STOCK . ".stock_qty 
    FROM " . DB_PRODUCT . " LEFT JOIN " . DB_IMAGE . " USING(product_id) LEFT JOIN " . DB_STOCK . " USING(product_id) 
    WHERE public_flg = 1 ORDER BY product_id";
    $stmt = $db->query($sql);

    echo '<div class="catalog_container">';
    foreach($stmt as $row) {
        echo '<div class="catalog_element">
            <a href="../ec_site/img/' . $row["image_name"] . '" target="_blank">
            <img src="../ec_site/img/' . $row["image_name"] . '"></a>
            <h3>' . $row["product_name"] . '</h3>
            <p>' . $row["price"] . '円</p>';
            if ($row["stock_qty"] == 0) {
                echo '<p class="red_text">売り切れ</p>';
            } else {
                echo '<form method="post">
                    <input type="hidden" name="select_product_name" value="' .$row['product_name'] . '">
                    <button name="select_product_id" value="' . $row['product_id'] . '">カートに追加する</button>
                </form>';
            }
        echo '</div>';
    }
    echo '</div>';
}

/**
 * 商品一覧画面と購入履歴画面でカートに入れるボタンが押された場合の挙動
 * catalog.phpとhistory.phpにて使用
 * 
 * @param object $db
 */
function post_catalog($db) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $select_product_id = $_POST['select_product_id'];
        $select_product_name = $_POST['select_product_name'];

        //セッションにcart_idが無ければDBとセッションにつくる
        if (empty($_SESSION['cart_id'])) {
            $sql_cart = "INSERT INTO " .DB_CART. " (user_id, create_date, update_date) 
            VALUES ('" . $_SESSION['user_id'] . "', '" . get_date() . "', '" . get_date() . "' )";
            suc_msg($sql_cart);
            $stmt = $db->query($sql_cart);
            if (!$stmt) {
                err_msg('カートに商品を追加できませんでした。再度お試しください。');
                return;
            }
            $sql_getid = "SELECT LAST_INSERT_ID()";
            $stmt =  $db->query($sql_getid);
            $result = $stmt->fetch();
            $cart_id = $result['LAST_INSERT_ID()'];
            $_SESSION['cart_id'] = $cart_id;
        } else {
            $cart_id = $_SESSION['cart_id'];
        }

        $db->beginTransaction();

        try {
            //ec_orderに、対応する商品のレコードを作る。既にある場合はproduct_qtyを増やす
            $eql_order_select = "SELECT order_id FROM " . DB_ORDER . " 
            WHERE cart_id = " . $cart_id . " AND product_id = " . $select_product_id . "";
            $stmt = $db->query($eql_order_select);
            $result = $stmt->fetch();

            if (!$result) {
                $sql_order_insert = "INSERT INTO " . DB_ORDER . " (cart_id, product_id, product_qty, 
                create_date, update_date) 
                VALUES (" . $cart_id . ", " . $select_product_id . ", 1, '" . get_date() . "', '" . get_date() . "')";
                $stmt = $db->query($sql_order_insert);
            } else {
                //レコードが存在するので、商品数を1増やす
                $sql_order_update = "UPDATE " . DB_ORDER . " 
                SET product_qty = product_qty + 1, update_date =  '" . get_date() . "' 
                WHERE order_id = " . $result['order_id'] . "";
                $stmt = $db->query($sql_order_update);
            }

            $db->commit();
            suc_msg($select_product_name . ' をカートに追加しました');
            if ($_SESSION['page_now'] == 'catalog') {
                header('Location: ./catalog.php');
                exit();
            } elseif ($_SESSION['page_now'] == 'history') {
                header('Location: ./history.php');
                exit();
            }
        } catch (PDOException $e){
            $db->rollback();
            err_msg('カートに商品を追加できませんでした。再度お試しください。');
        }
    }
}

/**
 * ショッピングカート画面の商品リスト作成
 * cart.phpにて使用
 * 
 * @param object $db
 */
function get_list_cart($db) {
    $cart_id = $_SESSION['cart_id'];
    if (empty($cart_id)) {  //カートが未生成
        echo '<p class="red_text">カートに商品が入っていません。</p>';
        return;        
    }

    $sql = "SELECT " . DB_CART . ".cart_id, " . DB_ORDER . ".order_id, " . DB_ORDER . ".product_id, " 
    . DB_ORDER . ".product_qty, " . DB_PRODUCT . ".product_name, " . DB_PRODUCT . ".price, " 
    . DB_IMAGE . ".image_name, " . DB_STOCK . ".stock_qty 
    FROM " . DB_CART . " LEFT JOIN " . DB_ORDER . " USING(cart_id) LEFT JOIN ". DB_PRODUCT . " USING(product_id) 
    LEFT JOIN " . DB_IMAGE . " USING(product_id) LEFT JOIN " . DB_STOCK . " USING(product_id) 
    WHERE cart_id = " . $cart_id . " ORDER BY order_id";
    $stmt = $db->query($sql);

    $price_sum = 0;
    echo '<table class="cart_list">';
    foreach ($stmt as $row){
        if (!$row['order_id']) {    //カートは有るが商品が空
            echo '<p class="red_text">カートに商品が入っていません。</p>';
            return;        
        }
        echo '<form method="post">
            <input type="hidden" name="order_id" value="' .$row['order_id'] . '">
            <input type="hidden" name="product_name" value="' .$row['product_name'] . '">
            <input type="hidden" name="stock_qty" value="' .$row['stock_qty'] . '">
            <tr>
                <td><a href="../ec_site/img/' . $row['image_name'] . '" target="_blank">
                <img src="../ec_site/img/' . $row['image_name'] . '"></a></td>
                <td>' . $row['product_name'] . '</td>
                <td>価格：' . $row['price'] . '円</td>
                <td><p class="small_text red_text">' . $row['stock_qty'] . '点まで注文できます</p>
                注文数<input type="number" class="input_value change_qty_form" name="product_qty" 
                value="' .$row['product_qty'] . '" min="1" max="' . $row['stock_qty'] . '">
                <button class="change_qty_btn" name="post_form" value="change_product_qty">注文数変更</button>
                <p class="red_text small_text change_qty_check_msg"></p></td>
                <td><button name="post_form" value="del_order">カートから削除</button></td>
            </tr>
        </form>';
        for ($i = 0; $i < $row['product_qty']; $i++) {
            $price_sum += $row['price'];
        }
    }
    echo '</table>';
    echo '<form method="post">
        <p class="purple_text subtotal">小計：　' . $price_sum . '円
        <button class="form_btn" name="post_form" value="confirm_order">購入する</button></p>
    </form>';
    $_SESSION['price_sum'] = $price_sum;
}

/**
 * カート画面からのPOSTが行われた場合の処理の振り分け
 * cart.phpにて使用
 * 
 * @param object $db
 */
function post_cart($db) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['post_form'] === 'change_product_qty'){
            change_product_qty($db);
        } elseif ($_POST['post_form'] === 'del_order') {
            del_order($db);
        } elseif ($_POST['post_form'] === 'confirm_order') {
            confirm_order($db);
        }
    }
}

/**
 * 注文数の変更
 * cart.phpにて使用
 * 
 * @param object $db
 */
function change_product_qty($db) {
    $select_order_id = $_POST['order_id'];
    $select_product_name = $_POST['product_name'];
    $select_product_qty = $_POST['product_qty'];
    $select_stock_qty = $_POST['stock_qty'];

    if ((!check_int_0($select_product_qty))
     or ($select_product_qty == 0)
     or ($select_product_qty > $select_stock_qty)) {
        err_msg('注文数を1～' . $select_stock_qty . 'の整数にしてください');
        return;
    }

    $sql_order_update = "UPDATE " . DB_ORDER . " 
    SET product_qty = " . $select_product_qty . ", update_date =  '" . get_date() . "' 
    WHERE order_id = " . $select_order_id . "";
    $stmt = $db->query($sql_order_update);

    suc_msg($select_product_name . ' の注文数を変更しました');
}

/**
 * 注文商品の削除
 * cart.phpにて使用
 * 
 * @param object $db
 */

function del_order($db) {
    $select_order_id = $_POST['order_id'];
    $select_product_name = $_POST['product_name'];

    $sql_del_order = "DELETE FROM " . DB_ORDER . " WHERE order_id = " . $select_order_id . "";
    $stmt = $db->query($sql_del_order);

    suc_msg($select_product_name . ' の注文を削除しました');
}

/**
 * 注文の確定・購入
 * cart.phpにて使用
 * 
 * @param object $db
 */
function confirm_order($db) {
    $cart_id = $_SESSION['cart_id'];
    $price_sum = $_SESSION['price_sum'];

    $sql = "SELECT " . DB_CART . ".cart_id, " . DB_ORDER . ".order_id, " . DB_ORDER . ".product_id, " 
    . DB_ORDER . ".product_qty, " . DB_PRODUCT . ".product_name, " . DB_STOCK . ".stock_qty 
    FROM " . DB_CART . " LEFT JOIN " . DB_ORDER . " USING(cart_id) LEFT JOIN ". DB_PRODUCT . " USING(product_id) 
    LEFT JOIN " . DB_STOCK . " USING(product_id) 
    WHERE cart_id = " . $cart_id . " ORDER BY order_id";
    $stmt = $db->query($sql);

    $db->beginTransaction();
    foreach ($stmt as $row) {
        if ($row['product_qty'] > $row['stock_qty']) {
            $db->rollback();
            err_msg($row['product_name'] . ' の在庫数が不足しています。');
            return;
        } else {
            $stock_next = $row['stock_qty'] - $row['product_qty'];
            $sql_stock_update = "UPDATE " . DB_STOCK . " 
            SET stock_qty = " . $stock_next . " , update_date =  '" . get_date() . "'
            WHERE product_id = " . $row['product_id'] . "";
            $stmt = $db->query($sql_stock_update);
        }
    }
    $db->commit();

    $sql_cart_update = "UPDATE " . DB_CART . " SET purchased_flg = 1 , update_date =  '" . get_date() . "' 
    WHERE cart_id = " . $cart_id . "";
    $stmt = $db->query($sql_cart_update);
    header('Location: ./thankyou.php');
    exit();
}

/**
 * 購入完了画面の商品リスト作成
 * thankyou.phpにて使用
 * 
 * @param object $db
 */
function get_list_thankyou($db) {
    $cart_id = $_SESSION['cart_id'];

    $sql = "SELECT " . DB_CART . ".cart_id, " . DB_ORDER . ".order_id, " . DB_ORDER . ".product_id, " 
    . DB_ORDER . ".product_qty, " . DB_PRODUCT . ".product_name, " . DB_PRODUCT . ".price, " . DB_IMAGE . ".image_name 
    FROM " . DB_CART . " LEFT JOIN " . DB_ORDER . " USING(cart_id) LEFT JOIN " . DB_PRODUCT . " USING(product_id) 
    LEFT JOIN " . DB_IMAGE . " USING(product_id) 
    WHERE cart_id = " . $cart_id . " ORDER BY order_id";
    $stmt = $db->query($sql);

    echo '<table class="thankyou_list">';
    foreach ($stmt as $row) {
        echo '<tr>
            <td><a href="../ec_site/img/' . $row['image_name'] . '" target="_blank">
            <img src="../ec_site/img/' . $row['image_name'] . '"></a></td>
            <td>' . $row['product_name'] . '</td>
            <td>価格：' . $row['price'] . '円</td>
            <td>注文数：' . $row['product_qty'] . '点</td>
        </tr>';
    }
    echo '</table>';
    $_SESSION['purchased'] = 1;
}

/**
 * 購入履歴画面の商品リスト作成
 * history.phpにて使用
 * 
 * @param object $db
 */
function get_list_history($db) {
    $user_id = $_SESSION['user_id'];

    $sql_cart = "SELECT cart_id, update_date FROM " . DB_CART . " 
    WHERE user_id = " . $user_id . " AND purchased_flg = 1 ORDER BY cart_id DESC";
    $stmt_cart = $db->query($sql_cart);

    foreach ($stmt_cart as $row) {
        $price_sum = 0;
        $sql_order = "SELECT " . DB_ORDER . ".product_id, " . DB_ORDER . ".product_qty, " 
        . DB_PRODUCT . ".product_name, " . DB_PRODUCT . ".price, " . DB_PRODUCT . ".public_flg, " 
        . DB_IMAGE . ".image_name, " . DB_STOCK . ".stock_qty 
        FROM " . DB_ORDER . " LEFT JOIN ". DB_PRODUCT . " USING(product_id) 
        LEFT JOIN " . DB_IMAGE . " USING(product_id) LEFT JOIN " . DB_STOCK . " USING(product_id) 
        WHERE cart_id = " . $row['cart_id'] . " ORDER BY order_id";
        $stmt_order = $db->query($sql_order);
        echo '<table class="history_list">';
        echo '<tr><td colspan="4" class="borderless"><div class="history_list_left purple_text">
        ご注文日：' . date('Y年m月d日' ,strtotime($row['update_date'])) . '</div></td></tr>';
        foreach ($stmt_order as $row2) {
            echo '<tr>
                <td><a href="../ec_site/img/' . $row2['image_name'] . '" target="_blank">
                <img src="../ec_site/img/' . $row2['image_name'] . '"></a></td>
                <td>' . $row2['product_name'] . '<BR>';
                if ($row2["public_flg"] != 1) {
                    echo '<div class="small_text red_text">現在ご注文いただけません</div>';
                } elseif ($row2["stock_qty"] == 0) {
                    echo '<div class="small_text red_text">現在売り切れ中です</div>';
                } else {
                    echo '<form method="post">
                        <input type="hidden" name="select_product_name" value="' .$row2['product_name'] . '">
                        <button name="select_product_id" value="' . $row2['product_id'] . '">カートに1点追加する</button>
                    </form>';
                }
                echo '</td>
                <td>価格：' . $row2['price'] . '円<BR>';
                echo '</td>
                <td>注文数：' . $row2['product_qty'] . '点</td>
            </tr>';
            for ($i = 0; $i < $row2['product_qty']; $i++) {
                $price_sum += $row2['price'];
            }
        }
        echo '<tr><td colspan="4" class="borderless"><div class="history_list_right purple_text">
        小計：　' . $price_sum . '円</div></td></tr>';
        echo '</table>';
    }
}

/**
 * ユーザー名のバリデーションチェック
 * index.php、registration.phpにて使用
 * 
 * @param string
 * @return int 1もしくは0
 */

function validate_name($str) {
    if (preg_match("/^\w{5,}$/", $str) === 0) {
        err_msg('ユーザー名は「5文字以上」かつ「半角英数字とアンダースコア」で入力してください');
        return 0;
    } else {
        return 1;
    }
}

/**
 * パスワードのバリデーションチェック
 * index.php、registration.phpにて使用
 * 
 * @param string
 * @return int 1もしくは0
 */

 function validate_pwd($str) {
    if (preg_match("/^\w{8,}$/", $str) === 0) {
        err_msg('パスワードは「8文字以上」かつ「半角英数字とアンダースコア」で入力してください');
        return 0;
    } else {
        return 1;
    }
}