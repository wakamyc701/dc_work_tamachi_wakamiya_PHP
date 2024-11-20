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
    </head>
    <body>
        <h3>画像投稿</h3>
        <?php
            if ($_SESSION['err_msg1'] == 1) {
                echo '<p style="color:#ff0000">エラー：画像名が送信されていません</p>';
                $_SESSION['err_msg1'] = 0;
            }
            if ($_SESSION['err_msg2'] == 1) {
                echo '<p style="color:#ff0000">エラー：画像名に半角英数字以外が含まれています<p>';
                $_SESSION['err_msg2'] = 0;
            }
            if ($_SESSION['err_msg3'] == 1) {
                echo '<p style="color:#ff0000">エラー：ファイルが送信されていません<p>';
                $_SESSION['err_msg3'] = 0;
            }
            if ($_SESSION['err_msg4'] == 1) {
                echo '<p style="color:#ff0000">エラー：画像の形式が「JPEG」「PNG」でありません<p>';
                $_SESSION['err_msg4'] = 0;
            }
            if ($_SESSION['post_success'] == 1) {
                echo '<p style="color:#0000ff">投稿されました<p>';
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

            $select = "SELECT image_id, image_name FROM w30gallery";
            if ($result = $db->query($select)){
                //連想配列を取得
                foreach ($result as $row){
                    //画像表示するように後で変更する
                    echo $row["image_id"] . $row["image_name"] . '<img src="img/' . $row["image_name"] . '"><br>';
                }
                //結果セットを閉じる
                $result->close();
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                
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