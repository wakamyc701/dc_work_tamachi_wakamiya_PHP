<?php
//session_start();

define('DSN','mysql:host=localhost;dbname=xb513874_joa6m');
define('LOGIN_USER','xb513874_cs97i');
define('PASSWORD','tu94ydpz6v');
define('DB_TABLE','w30gallery');

$image_id;
$image_name;
$public_flg;
$create_datde;
$update_date;

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
 * 画像の表示・非表示フラグの取得
 * 
 * @param int $change_flg_id フラグを取得する画像のimage_id
 * @return string $select フラグを取得する画像のimage_idのSELECT文
 */
function get_flg($change_flg_id){
    $select = "SELECT public_flg FROM ".DB_TABLE." WHERE image_id = '" . $change_flg_id . "'";
    return $select;
}

/**
 * 画像の表示・非表示フラグの変更のUPDATE文取得
 * 
 * @param int $change_flg_id フラグを変更する画像のimage_id
 * @param int $flg_new 変更後のフラグ
 * @return string $update フラグを変更する画像のimage_idのUPDATE文
 */
function update_flg($change_flg_id,$flg_new) {
    $date = date("Y-m-d");
    $update = "UPDATE ".DB_TABLE." SET public_flg = $flg_new, update_date = '".$date."' WHERE image_id = " . $change_flg_id ;
    return $update;
}

/**
 * 画像の表示・非表示フラグの変更を実行
 * 
 * @param object $db
 */

function change_flg_execution($db){
    $change_flg_id = $_POST['change_flg_id'];
//  echo "image_id:".$change_flg_id."<br>";
    $flg = $db->query(get_flg($change_flg_id));

    foreach ($flg as $row_flg) {
        $current_public_flg = $row_flg['public_flg'];
    }

//  echo "public_flg".$current_public_flg."<br>";

    if ($current_public_flg == 0) {
        $hide_image = update_flg($change_flg_id,1);
        if ($result_update = $db->query($hide_image)) {
            $_SESSION['suc_msg'] = '画像を非表示にしました';
//  echo '画像を非表示にしました';
        } else {
            $_SESSION['err_msg'][] = 'UPDATE実行エラー' . $hide_image;
        }
    } else {
        $show_image = update_flg($change_flg_id,0);
        if ($result_update = $db->query($show_image)) {
            $_SESSION['suc_msg'] = '画像を表示にしました';
//  echo '画像を表示にしました';
        } else {
            $_SESSION['err_msg'][] = 'UPDATE実行エラー' . $show_image;
        }
    }
}

/**
 * 画像投稿のINSERT文取得
 * 
 * @param string $post_title 画像名
 * @return string $insert 画像投稿のINSERT文
 */
function insert_img($post_title) {
    $date = date("Y-m-d");
    $insert = "INSERT INTO ".DB_TABLE." (
        image_name,
        create_date,
        update_date
    ) VALUES (
        '$post_title',
        '$date',
        '$date'
    );";
    return $insert;
}

/**
 * 画像名のバリテーションチェック、ファイル形式のチェック
 * 
 * @param string $post_title 画像名
 * @param int $size_image 画像サイズ
 * @param string $type_image 画像ファイルのMIME型
 * @return int $isError エラーがあれば1、無ければ0
 * 
 */
function check_input_err($post_title,$size_image,$type_image) { //画像名・ファイルのバリデーションチェック
    $isError = 0;
    if ((!isset($post_title)) or ($post_title == "")) {   //画像名が無い
        $_SESSION['err_msg'][] = 'エラー：画像名が送信されていません';
        $isError = 1;
    } elseif (!preg_match("/^[a-zA-Z0-9]+$/", $post_title)) {    //画像名に半角英数字以外が含まれる
        $_SESSION['err_msg'][] = 'エラー：画像名に半角英数字以外が含まれています';
        $isError = 1;
    }
    if ($size_image == 0) { //ファイルが送信されていない
        $_SESSION['err_msg'][] = 'エラー：ファイルが送信されていません';
        $isError = 1;
    } elseif (($type_image != 'image/jpeg') && ($type_image != 'image/png')){   //ファイル形式が異なる
        $_SESSION['err_msg'][] = 'エラー：ファイルの形式が「JPEG」「PNG」でありません';
        $isError = 1;
    }
    return $isError;
}

/**
 * 画像投稿の実行
 * 
 * @param object $db
 */
function add_image($db){
    $db->beginTransaction();   //トランザクション開始

    //データベースへの書き込み
    if ($_FILES['upload_image']['type'] == 'image/jpeg') {
        $post_title = $_POST['post_title'].".jpeg";
    } else {
        $post_title = $_POST['post_title'].".png";
    }

    $insert = insert_img($post_title);

    if (!$db->query($insert)){
        $_SESSION['err_msg'][] = 'INSERT実行エラー' . $insert;
        $db->rollback();  //INSERT実行エラーなのでロールバック
    } else {
        //画像のアップロード
        $save = '../work30/img/' . $post_title;

        if(move_uploaded_file($_FILES['upload_image']['tmp_name'],$save)){
            $db->commit();  //アップロード成功
            $_SESSION['suc_msg'] = 'アップロード成功しました';
        } else {
            $db->rollback();    //アップロード失敗なのでロールバック
            $_SESSION['err_msg'][] = 'アップロード失敗しました';
        }
    }
}

/**
 * POST内容が表示・非表示フラグの変更か画像投稿かの切り分け
 * 
 * @param object $db
 */
function check_post($db){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //var_dump($_POST);

        //フラグ変更の場合
        if (isset($_POST['change_flg_id'])) {
            change_flg_execution($db);
            header('Location: ./work39.php');
            exit();
        }

        //画像投稿の場合
        $isError = check_input_err($_POST['post_title'],$_FILES['upload_image']['size'],$_FILES['upload_image']['type']);
        if ($isError == 0) {    //入力内容にエラーが無かった場合のみ画像投稿実行
            add_image($db);
        }
        header('Location: ./work39.php');
        exit();
    }
}

/**
 * 画像投稿／表示・非表示フラグ変更後のメッセージ表示
 */
function display_msg() {
    if (count($_SESSION['err_msg']) != 0) { //エラー有り
        foreach ($_SESSION['err_msg'] as $err_each) {
            echo '<p class="err_msg">'.$err_each.'</p>';
        }
        $_SESSION['err_msg'] = [];
    }
    if (isset($_SESSION['suc_msg'])) {
        echo '<p class="success_msg">'.$_SESSION['suc_msg'].'<p>';
        $_SESSION['suc_msg'] = null;
    }
}

/**
 * 画像一覧の表示
 * 
 * @param var $result 表示内容の結果セット
 * @param string $current_page 画像投稿ページならpost、画像一覧ページならgallery
 */
function display_gallery($result, $current_page) { //画像一覧表示
    echo '<div class="gallery_box">';
    foreach ($result as $row){  //連想配列を取得
        if ($row['public_flg'] == 0){   //表示
            echo '<div class="gallery_element">' . $row["image_name"] . '<br><a href="../work30/img/' . $row["image_name"] . '" target="_blank"><img src="../work30/img/' . $row["image_name"] . '"></a>';
            if ($current_page == 'post'){
                echo '<br><button form="img_post" name="change_flg_id" value="'.$row["image_id"].'">非表示にする</button>';
            }
            echo '</div>';
        } else{   //非表示
            if ($current_page == 'post') {
                echo '<div class="gallery_element gallery_element_close">'. $row["image_name"] . '<br><a href="../work30/img/' . $row["image_name"] . '" target="_blank"><img src="../work30/img/' . $row["image_name"] . '"></a>';
                echo '<br><button form="img_post" name="change_flg_id" value="'.$row["image_id"].'">表示する</button>';
                echo '</div>';
            }
        }
    }
    echo '</div>';
}
