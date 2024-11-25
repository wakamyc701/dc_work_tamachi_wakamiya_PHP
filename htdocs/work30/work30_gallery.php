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
    $update_date
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK30 画像一覧ページ</title>
        <style>
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
            .gallery_element img {
                width: 240px;
                height: 240px;
                object-fit: contain;
            }
        </style>
    </head>
    <body>
        <?php
            //データベースへ接続
            $db = new mysqli($host, $login_user, $password, $database);
            if ($db->connect_error){
                echo $db->connect_error;
                exit();
            }else{
                $db->set_charset("UTF8");
            }

            //SELECT文の実行
            print '<h3>画像一覧</h3>';
            $select = "SELECT image_id, image_name, public_flg FROM w30gallery WHERE public_flg = 0";
            if ($result = $db->query($select)){
                echo '<div class="gallery_box">';
                //連想配列を取得
                foreach ($result as $row){
                    if ($row['public_flg'] == 0){   //表示
                        echo '<div class="gallery_element">' . $row["image_name"] . '<br>
                        <a href="img/'.$row["image_name"].'" target="_blank"><img src="img/' . $row["image_name"].'"></a></div>';
                    }
                }
                echo '</div>';
                //結果セットを閉じる
                $result->close();
                print '<p><a href="work30.php">画像投稿ページへ</a></p>';
            }
            $db->close();
        ?>
    </body>
</html>