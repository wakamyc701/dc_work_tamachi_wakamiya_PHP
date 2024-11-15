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
        <title>WORK30 画像投稿ページ</title>
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

            //今は仮にギャラリーページのまま。ここにフォームとか入れていく
            print '<h3>画像投稿</h3>';
            $select = "SELECT image_id, image_name FROM w30gallery WHERE public_flg = 0";
            if ($result = $db->query($select)){
                //連想配列を取得
                foreach ($result as $row){
                    //画像表示するように後で変更する
                    echo $row["image_id"] . $row["image_name"] . "<br>";
                }
                //結果セットを閉じる
                $result->close();
                print '<a href="work30_gallery.php">画像一覧ページへ</a>';
            }
            $db->close();
        ?>
    </body>
</html>