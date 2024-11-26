<?php
    $dsn = 'mysql:host=localhost;dbname=xb513874_joa6m';
    $login_user = 'xb513874_cs97i';
    $password = 'tu94ydpz6v';
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>TRY45</title>
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
            $sql = "SELECT product_name, price FROM product WHERE price <= 100";
            if ($result = $db->query($sql)){
                //連想配列を取得
                while ($row = $result->fetch()){
                    echo $row['product_name'] . $row['price'] . "<br>";
                }
            }
        ?>
    </body>
</html>
