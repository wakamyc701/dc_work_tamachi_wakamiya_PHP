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
            if ($_SESSION['err_msg3'] == 1) {
                echo '<p style="color:#ff0000">エラー：画像名に半角英数字以外が含まれています<p>';
                $_SESSION['err_msg3'] = 0;
            }
            if ($_SESSION['err_msg2'] == 1) {
                echo '<p style="color:#ff0000">エラー：ファイルが送信されていません<p>';
                $_SESSION['err_msg2'] = 0;
            }
            if ($_SESSION['err_msg4'] == 1) {
                echo '<p style="color:#ff0000">エラー：ファイル拡張子がjpgでありません<p>';
                $_SESSION['err_msg4'] = 0;
            }
            if ($_SESSION['post_success'] == 1) {
                echo '<p style="color:#0000ff">POSTされました<p>';
                $_SESSION['post_success'] = 0;
            }
        ?>

        <form method="post" enctype="multipart/form-data">
            <p>画像名：<input type="text" name="post_title">　※半角英数字のみ使用してください</p>
            <p>画像　：<input type="file" name="upload_image">※投稿できる画像の形式は「.jpg」「.jpeg」「.png」のみです</p>
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
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                
                //入力情報不足時の処理
                $isError = 0;

                if ((!isset($_POST['post_title'])) or ($_POST['post_title'] == "")) {   //画像名が無い
                    $_SESSION['err_msg1'] = 1;
                    $isError = 1;
                }

                if ($_FILES['upload_image']['size'] == 0) { //ファイルが送信されていない
                    $_SESSION['err_msg2'] = 1;
                    $isError = 1;
                }

                if (!preg_match("/^[a-zA-Z0-9]+$/", $_POST['post_title']) && $_POST['post_title'] !== '') {    //画像名に半角英数字以外が含まれる
                    $_SESSION['err_msg3'] = 1;
                    $isError = 1;
                }

                //ここ、$_FILES['upload_image']['type']で条件分けした方が簡単
                if (!preg_match("/^.*[j]+[p]{1}[g]{1}$/", $_FILES['upload_image']['name']) && $_FILES['upload_image']['size'] != 0){
                    $_SESSION['err_msg4'] = 1;
                    $isError = 1;
                }


                if ($isError == 0) {
                    $_SESSION['post_success'] = 1;
                }

                header('Location: ./work30.php');
                exit;
            }


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

            $select = "SELECT image_id, image_name FROM w30gallery WHERE public_flg = 0";
            if ($result = $db->query($select)){
                //連想配列を取得
                foreach ($result as $row){
                    //画像表示するように後で変更する
                    echo $row["image_id"] . $row["image_name"] . "<br>";
                }
                //結果セットを閉じる
                $result->close();
            }

            $db->close();
        ?>

    </body>
</html>