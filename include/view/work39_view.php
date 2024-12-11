<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <?php
        if ($current_page == 'post') {
            echo '<title>WORK39 画像投稿ページ</title>';
        } else {
            echo '<title>WORK39 画像一覧ページ</title>';
        }
        ?>

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
        <?php
            if ($current_page == 'post'){
                echo '<h1>画像投稿</h1>';

                if (empty($_SESSION['err_msg'])) {
                    $_SESSION['err_msg'] = [];
                }
                //var_dump($_SESSION['err_msg']);
    
                display_msg();

                echo '
                <form method="post" enctype="multipart/form-data" id="img_post">
                    <p>画像名：<input type="text" name="post_title">　※半角英数字のみ使用してください</p>
                    <p>画像　：<input type="file" name="upload_image">※投稿できる画像の形式は「JPEG」「PNG」のみです</p>
                    <input type="submit" value="画像投稿">
                </form>
                <p><a href="work39_gallery.php">画像一覧ページへ</a></p>
                ';
    
            } else {
                echo '<h1>画像一覧</h1>';
            }

            $select = "SELECT image_id, image_name, public_flg FROM w30gallery ORDER BY image_id";
            if ($result = $db->query($select)){
                display_gallery($result, $current_page);
                //結果セットを閉じる
                //$result->close();
            }

            if ($current_page == 'gallery') {
                echo '<p><a href="work39.php">画像投稿ページへ</a></p>';
            }
        ?>
    </body>
</html>