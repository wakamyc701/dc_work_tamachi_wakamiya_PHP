<?php
    $dsn = 'mysql:host=localhost;dbname=xb513874_joa6m';
    $login_user = 'xb513874_cs97i';
    $password = 'tu94ydpz6v';
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK31</title>
    </head>
    <body>
        <?php
            try{
                //データベースへ接続
                $db = new PDO($dsn,$login_user,$password);
            } catch (PDOException $e){
                echo $e->getMessage();
                exit();
            }
            //SELECT文の実行
            $sql1 = "SELECT * FROM product WHERE category_id = 1";
            $sql2 = "SELECT category_name FROM category WHERE category_id = 1";

            if ($result1 = $db->query($sql1)){
                if ($result2 = $db->query($sql2)){
                    //連想配列を取得
                    $row2 = $result2->fetch(PDO::FETCH_ASSOC);
                    while ($row1 = $result1->fetch()){
                        echo $row1['product_id'] .'　'. $row1['product_code'] .'　'. $row1['product_name'] .'　'. $row1['price'] .'　'. $row1['category_id'] .'　'. $row2['category_name'] . "<br>";
                    }
                }
            }
        ?>
    </body>
</html>
