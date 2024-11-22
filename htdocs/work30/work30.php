<?php
    $host = 'localhost';
    $login_user = 'xb513874_cs97i';
    $password = 'tu94ydpz6v';
    $database = 'xb513874_joa6m';
    $error_msg = [];
    $image_id;
    $image_name;
    $public_flg;
    $create_datde;
    $update_date;

    /*
    $post_title;
    if (isset($_POST['post_title'])) {
        $post_title = htmlspecialchars($_POST['post_title'],ENT_QUOTES,'UTF-8');
    };
    */

//    $tmp = 0;

    // $_SESSIONを使う必要があるのではないか？（投稿時のメッセージ表示のために）
    session_start();
    
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK30 画像投稿ページ</title>
        <style>
            .err_msg {
                color: #ff0000;
            }
            .success_msg {
                color: #0000ff;
            }
            .gallery_box {
                display: flex;
                flex-wrap: wrap;
            }
            .gallery_element {
                width: 320px;
                text-align: center;
                margin: 4px;
                padding: 4px;
                border: solid 2px #bbbbbb;
            }
            .gallery_element_close {
                background-color: #888888;
            }
            .gallery_element img {
                width: 300px;
                height: 300px;
                object-fit: contain;
            }
        </style>
    </head>
    <body>
        <h3>画像投稿</h3>
        <?php
            if ($_SESSION['err_msg1'] == 1) {
                echo '<p class="err_msg">エラー：画像名が送信されていません</p>';
                $_SESSION['err_msg1'] = 0;
            }
            if ($_SESSION['err_msg2'] == 1) {
                echo '<p class="err_msg">エラー：画像名に半角英数字以外が含まれています<p>';
                $_SESSION['err_msg2'] = 0;
            }
            if ($_SESSION['err_msg3'] == 1) {
                echo '<p class="err_msg">エラー：ファイルが送信されていません<p>';
                $_SESSION['err_msg3'] = 0;
            }
            if ($_SESSION['err_msg4'] == 1) {
                echo '<p class="err_msg">エラー：画像の形式が「JPEG」「PNG」でありません<p>';
                $_SESSION['err_msg4'] = 0;
            }
            if ($_SESSION['post_success'] == 1) {
                echo '<p class="success_msg">投稿されました<p>';
                $_SESSION['post_success'] = 0;
            }
        ?>

        <form method="post" enctype="multipart/form-data">
            <p>画像名：<input type="text" name="post_title">　※半角英数字のみ使用してください</p>
            <p>画像　：<input type="file" name="upload_image">※投稿できる画像の形式は「JPEG」「PNG」のみです</p>
            <input type="submit" value="画像投稿">
        </form>

        <p><a href="work30_gallery.php">画像一覧ページへ</a></p>

        <?php

/*
            //入力情報不足時の処理
            if ((!isset($_POST['post_title'])) or ($_POST['post_title'] == "")) {
                //$errmsg1 = $errmsg1 + 1;
                //$errmsg1 = '画像名が送信されていません';
                echo 'A画像名が送信されていません';
            }

       
            if (!isset($_FILES['upload_image'])) {
//            if ($_FILES['upload_image']['size'] == 0) {
                    echo 'Bファイルが送信されていません';
            }
*/
            
            /*
            //画像アップロード
            $save = 'img/' . basename($_FILES['upload_image']['name']);
        
            if(move_uploaded_file($_FILES['upload_image']['tmp_name'],$save)){
                echo 'アップロード成功しました。';
            } else {
                echo 'アップロード失敗しました。';
                exit;
            }
            */

            //データベースへ接続
            $db = new mysqli($host, $login_user, $password, $database);
            if ($db->connect_error){
                echo $db->connect_error;
                exit();
            }else{
                $db->set_charset("UTF8");
            }

            $select = "SELECT image_id, image_name, public_flg FROM w30gallery ORDER BY image_id";
            if ($result = $db->query($select)){
                //連想配列を取得
                echo '<div class="gallery_box">';

                foreach ($result as $row){
                    if ($row['public_flg'] == 0){   //表示
                        echo '<div class="gallery_element">'.$row["image_id"] . '.' . $row["image_name"] . '<br>
                        <img src="img/' . $row["image_name"].'"><br>';
                        echo '<form method="post" enctype="multipart/form-data"><button name="change_flg_id" value="'.$row["image_id"].'">非表示にする</button></form>';
                    } else {    //非表示
                        echo '<div class="gallery_element gallery_element_close">'.$row["image_id"] . '.' . $row["image_name"] . '<br>
                        <img src="img/' . $row["image_name"].'"><br>';
                        echo '<form method="post" enctype="multipart/form-data"><button name="change_flg_id" value="'.$row["image_id"].'">表示する</button></form>';
                    }
                    echo '</div>';
                }

                echo '</div>';

                //結果セットを閉じる
                $result->close();
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                //表示・非表示の変更の場合
                $change_flg_id = $_POST['change_flg_id'];
                if (isset($_POST['change_flg_id'])) {
                    echo "image_id:".$change_flg_id."<br>";
//                    $flg = "SELECT public_flg FROM w30gallery WHERE image_id = '14'";
//                    $flg = $db->query("SELECT public_flg FROM w30gallery WHERE image_id = '14'");
//                    $flg = "SELECT public_flg FROM w30gallery WHERE image_id = '" . $change_flg_id . "'";
                    $flg = $db->query("SELECT public_flg FROM w30gallery WHERE image_id = '" . $change_flg_id . "'");
//                  $flg = "SELECT public_flg FROM w30gallery WHERE image_id = $change_flg_id";

                    foreach ($flg as $row_flg) {
                        $current_public_flg = $row_flg['public_flg'];
                    }

                    echo "public_flg".$current_public_flg."<br>";
                    if ($current_public_flg == 0) {
                        echo '非表示にします';
                    } else {
                        echo '表示します';
                    }
                    exit;
                }
                
                //入力情報が形式に合っているかの確認
                $isError = 0;

                if ((!isset($_POST['post_title'])) or ($_POST['post_title'] == "")) {   //画像名が無い
                    $_SESSION['err_msg1'] = 1;
                    $isError = 1;
                } elseif (!preg_match("/^[a-zA-Z0-9]+$/", $_POST['post_title'])) {    //画像名に半角英数字以外が含まれる
                    $_SESSION['err_msg2'] = 1;
                    $isError = 1;
                }

                if ($_FILES['upload_image']['size'] == 0) { //ファイルが送信されていない
                    $_SESSION['err_msg3'] = 1;
                    $isError = 1;
                } elseif (($_FILES['upload_image']['type'] != 'image/jpeg') && ($_FILES['upload_image']['type'] != 'image/png')){   //ファイル形式が異なる
                    $_SESSION['err_msg4'] = 1;
                    $isError = 1;
                }

                //入力内容にエラーが無かった場合
                if ($isError == 0) {
                    $db->begin_transaction();   //トランザクション開始

                    //データベースへの書き込み
                    if ($_FILES['upload_image']['type'] == 'image/jpeg') {
                        $post_title = $_POST['post_title'].".jpeg";
                    } else {
                        $post_title = $_POST['post_title'].".png";
                    }
                    //echo $post_title;
                    $date = date("Y-m-d");
                    //echo $date;

                    $insert = "INSERT INTO w30gallery(
                        image_name,
                        create_date,
                        update_date
                    ) VALUES (
                        '$post_title',
                        '$date',
                        '$date'
                    );";

                    if (!$db->query($insert)){
                        $db->rollback();  //INSERT実行エラーなのでロールバック
                    } else {
                        //画像のアップロード
                        $save = 'img/' . $post_title;

                        if(move_uploaded_file($_FILES['upload_image']['tmp_name'],$save)){
                            $db->commit();  //アップロード成功
                            $_SESSION['post_success'] = 1;

                        } else {
                            $db->rollback();    //アップロード失敗なのでロールバック
                        }

                    }
                    
                }

                header('Location: ./work30.php');
                exit;
            }


            $db->close();
        ?>

    </body>
</html>