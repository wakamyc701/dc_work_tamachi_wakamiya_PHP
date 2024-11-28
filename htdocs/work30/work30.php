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
                width: 250px;
                text-align: center;
                margin: 4px;
                padding: 4px;
                border: solid 2px #bbbbbb;
            }
            .gallery_element_close {
                background-color: #888888;
            }
            .gallery_element img {
                width: 240px;
                height: 240px;
                object-fit: contain;
            }
        </style>
    </head>
    <body>
        <h3>画像投稿</h3>
        <?php
            if (empty($_SESSION['err_msg'])) {
                $_SESSION['err_msg'] = [];
           }
//            var_dump($_SESSION['err_msg']);
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
        ?>

        <form method="post" enctype="multipart/form-data" id="img_post">
            <p>画像名：<input type="text" name="post_title">　※半角英数字のみ使用してください</p>
            <p>画像　：<input type="file" name="upload_image">※投稿できる画像の形式は「JPEG」「PNG」のみです</p>
            <input type="submit" value="画像投稿">
        </form>

        <p><a href="work30_gallery.php">画像一覧ページへ</a></p>

        <?php
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
//                        echo '<div class="gallery_element">' . $row["image_name"] . '<br><a href="img/' . $row["image_name"] . '" target="_blank"><img src="img/' . $row["image_name"] . '"></a><br>';
                        echo '<p><div class="gallery_element">' .$row['public_flg']. $row["image_name"] . '</p><p><img src="img/' . $row["image_name"] . '"></p>';
//                        echo '<form method="post" enctype="multipart/form-data"><button name="change_flg_id" value="'.$row["image_id"].'">非表示にする</button></form>';
                        echo '<p><button form="img_post" name="change_flg_id" value="'.$row["image_id"].'">非表示にする</button></p>';
                    } else {    //非表示
//                           echo '<div class="gallery_element gallery_element_close">' . $row["image_name"] . '<br><a href="img/' . $row["image_name"] . '" target="_blank"><img src="img/' . $row["image_name"] . '"></a><br>';
                        echo '<p><div class="gallery_element gallery_element_close">' .$row['public_flg']. $row["image_name"] . '</p><p><img src="img/' . $row["image_name"] . '"></p>';
//                        echo '<form method="post" enctype="multipart/form-data"><button name="change_flg_id" value="'.$row["image_id"].'">表示する</button></form>';
                        echo '<p><button form="img_post" name="change_flg_id" value="'.$row["image_id"].'">表示する</button></p>';
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
                    $flg = $db->query("SELECT public_flg FROM w30gallery WHERE image_id = '" . $change_flg_id . "'");

                    foreach ($flg as $row_flg) {
                        $current_public_flg = $row_flg['public_flg'];
                    }

                    echo "public_flg".$current_public_flg."<br>";
                    $date = date("Y-m-d");
                    if ($current_public_flg == 0) {
                        $hide_image = "UPDATE w30gallery SET public_flg = 1, update_date = '".$date."' WHERE image_id = '" . $change_flg_id . "'";
                        if ($result_update = $db->query($hide_image)) {
                            $_SESSION['suc_msg'] = '画像を非表示にしました';
                        } else {
                            $_SESSION['err_msg'][] = 'UPDATE実行エラー' . $hide_image;
                        }
                    } else {
                        $show_image = "UPDATE w30gallery SET public_flg = 0, update_date = '".$date."' WHERE image_id = '" . $change_flg_id . "'";
                        if ($result_update = $db->query($show_image)) {
                            $_SESSION['suc_msg'] = '画像を表示にしました';
                        } else {
                            $_SESSION['err_msg'][] = 'UPDATE実行エラー' . $show_image;
                        }
                    }
                    header('Location: ./work30.php');
                    exit();
                }
                
                //入力情報が形式に合っているかの確認
                $isError = 0;

                if ((!isset($_POST['post_title'])) or ($_POST['post_title'] == "")) {   //画像名が無い
                    $_SESSION['err_msg'][] = 'エラー：画像名が送信されていません';
                    $isError = 1;
                } elseif (!preg_match("/^[a-zA-Z0-9]+$/", $_POST['post_title'])) {    //画像名に半角英数字以外が含まれる
                    $_SESSION['err_msg'][] = 'エラー：画像名に半角英数字以外が含まれています';
                    $isError = 1;
                }
                if ($_FILES['upload_image']['size'] == 0) { //ファイルが送信されていない
                    $_SESSION['err_msg'][] = 'エラー：ファイルが送信されていません';
                    $isError = 1;
                } elseif (($_FILES['upload_image']['type'] != 'image/jpeg') && ($_FILES['upload_image']['type'] != 'image/png')){   //ファイル形式が異なる
                    $_SESSION['err_msg'][] = 'エラー：ファイルの形式が「JPEG」「PNG」でありません';
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
                    $date = date("Y-m-d");

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
                        $_SESSION['err_msg'][] = 'INSERT実行エラー' . $insert;
                        $db->rollback();  //INSERT実行エラーなのでロールバック
                    } else {
                        //画像のアップロード
                        $save = 'img/' . $post_title;

                        if(move_uploaded_file($_FILES['upload_image']['tmp_name'],$save)){
                            $db->commit();  //アップロード成功
                            $_SESSION['suc_msg'] = 'アップロード成功しました';
                        } else {
                            $_SESSION['err_msg'][] = 'アップロード失敗しました';
                            $db->rollback();    //アップロード失敗なのでロールバック
                        }
                    }
                }
                header('Location: ./work30.php');
                exit();
            }
            $db->close();
        ?>
    </body>
</html>