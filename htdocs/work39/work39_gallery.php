<?php
require_once '../../include/model/work39_model.php';
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK39 画像一覧ページ</title>
        <style type="text/css">
            h1 {
                font-size: 1.5em;
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
            .gallery_element img {
                width: 240px;
                height: 240px;
                object-fit: contain;
            }
        </style>
    </head>
    <body>
        <?php
            try{
                function display_gallery($result) {
                    echo '<div class="gallery_box">';
                    //連想配列を取得
                    foreach ($result as $row){
                        if ($row['public_flg'] == 0){   //表示
                            echo '<div class="gallery_element">' . $row["image_name"] . '<br>
                            <a href="../work30/img/'.$row["image_name"].'" target="_blank"><img src="../work30/img/' . $row["image_name"].'"></a></div>';
                        }
                    }
                    echo '</div>';
                }
   
                $db = connect_db();
                $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        
                //SELECT文の実行
                print '<h1>画像一覧</h1>';
                $select = "SELECT image_id, image_name, public_flg FROM w30gallery WHERE public_flg = 0";
                if ($result = $db->query($select)){
                    display_gallery($result);
                    //結果セットを閉じる
                    //$result->close();
                    print '<p><a href="work39.php">画像投稿ページへ</a></p>';
                }
            } catch (PDOException $e){
                echo $e->getMessage();
                exit();
            }
        ?>
    </body>
</html>