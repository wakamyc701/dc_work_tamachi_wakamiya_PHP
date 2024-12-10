<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK39 画像投稿ページ</title>
        <style type="text/css">
            h1 {
                font-size: 1.5em;
            }
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
        <h1>画像投稿</h1>
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

        <p><a href="work39_gallery.php">画像一覧ページへ</a></p>

        <?php
            function display_gallery($result) { //画像一覧表示
                echo '<div class="gallery_box">';
                foreach ($result as $row){  //連想配列を取得
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
            }

            $select = "SELECT image_id, image_name, public_flg FROM w30gallery ORDER BY image_id";
            if ($result = $db->query($select)){
                display_gallery($result);
                //結果セットを閉じる
                //$result->close();
            }
        ?>
    </body>
</html>