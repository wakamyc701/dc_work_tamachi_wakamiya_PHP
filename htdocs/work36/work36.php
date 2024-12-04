<?php
    define('DSN','mysql:host=localhost;dbname=xb513874_joa6m');
    define('LOGIN_USER','xb513874_cs97i');
    define('PASSWORD','tu94ydpz6v');
    define('DB_TABLE','w30gallery');
    $error_msg = [];
    $image_id;
    $image_name;
    $public_flg;
    $create_datde;
    $update_date;

    //$_POST = array();
    session_start();

    try{
        function connect_db() { //データベースへ接続
            $db = new PDO(DSN,LOGIN_USER,PASSWORD);
            return $db;
        }

        function get_flg($change_flg_id){   //画像の表示・非表示フラグの取得
            $select = "SELECT public_flg FROM ".DB_TABLE." WHERE image_id = '" . $change_flg_id . "'";
            return $select;
        }

        function update_flg($change_flg_id,$flg_new) {  //画像の表示・非表示フラグの変更
            $date = date("Y-m-d");
            $update = "UPDATE ".DB_TABLE." SET public_flg = $flg_new, update_date = '".$date."' WHERE image_id = " . $change_flg_id ;
            return $update;
        }

        function insert_img($post_title) {  //画像投稿
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

        $db = connect_db();
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //var_dump($_POST);

            //表示・非表示の変更の場合
            if (isset($_POST['change_flg_id'])) {
                $change_flg_id = $_POST['change_flg_id'];
//                echo "image_id:".$change_flg_id."<br>";
                $flg = $db->query(get_flg($change_flg_id));

                foreach ($flg as $row_flg) {
                    $current_public_flg = $row_flg['public_flg'];
                }

//                echo "public_flg".$current_public_flg."<br>";

                if ($current_public_flg == 0) {
                    $hide_image = update_flg($change_flg_id,1);
                    if ($result_update = $db->query($hide_image)) {
                        $_SESSION['suc_msg'] = '画像を非表示にしました';
//                        echo '画像を非表示にしました';
                    } else {
                        $_SESSION['err_msg'][] = 'UPDATE実行エラー' . $hide_image;
                    }
                } else {
                    $show_image = update_flg($change_flg_id,0);
                    if ($result_update = $db->query($show_image)) {
                        $_SESSION['suc_msg'] = '画像を表示にしました';
//                        echo '画像を表示にしました';
                    } else {
                        $_SESSION['err_msg'][] = 'UPDATE実行エラー' . $show_image;
                    }
                }
                header('Location: ./work36.php');
                exit();
            }

            $isError = check_input_err($_POST['post_title'],$_FILES['upload_image']['size'],$_FILES['upload_image']['type']);

            //入力内容にエラーが無かった場合
            if ($isError == 0) {
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
            header('Location: ./work36.php');
            exit();
        }
    } catch (PDOException $e){
        echo $e->getMessage();
        exit();
    }

//    $db->close();
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK36 画像投稿ページ</title>
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
            function display_msg() {   //投稿後・フラグ変更後のメッセージ表示
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

            if (empty($_SESSION['err_msg'])) {
                $_SESSION['err_msg'] = [];
            }
            //var_dump($_SESSION['err_msg']);

            display_msg();
        ?>

        <form method="post" enctype="multipart/form-data" id="img_post">
            <p>画像名：<input type="text" name="post_title">　※半角英数字のみ使用してください</p>
            <p>画像　：<input type="file" name="upload_image">※投稿できる画像の形式は「JPEG」「PNG」のみです</p>
            <input type="submit" value="画像投稿">
        </form>

        <p><a href="work36_gallery.php">画像一覧ページへ</a></p>

        <?php
            $select = "SELECT image_id, image_name, public_flg FROM w30gallery ORDER BY image_id";
            if ($result = $db->query($select)){
                //連想配列を取得
                echo '<div class="gallery_box">';

                foreach ($result as $row){
                    if ($row['public_flg'] == 0){   //表示
                        echo '<div class="gallery_element">' . $row["image_name"] . '<br><a href="../work30/img/' . $row["image_name"] . '" target="_blank"><img src="../work30/img/' . $row["image_name"] . '"></a><br>';
                        echo '<button form="img_post" name="change_flg_id" value="'.$row["image_id"].'">非表示にする</button>';
                    } else {    //非表示
                        echo '<div class="gallery_element gallery_element_close">'. $row["image_name"] . '<br><a href="../work30/img/' . $row["image_name"] . '" target="_blank"><img src="../work30/img/' . $row["image_name"] . '"></a><br>';
                        echo '<button form="img_post" name="change_flg_id" value="'.$row["image_id"].'">表示する</button>';
                    }
                    echo '</div>';
                }
                echo '</div>';

                //結果セットを閉じる
//                $result->close();
            }
        ?>
    </body>
</html>