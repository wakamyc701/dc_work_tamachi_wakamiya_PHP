<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>TRY39</title>
    </head>
    <body>
        <?php
            //データベースへ接続
            $db = new mysqli('localhost', 'xb513874_cs97i', 'tu94ydpz6v', 'xb513874_joa6m');
            if ($db->connect_error){
                echo $db->connect_error;
                exit();
            }else{
                $db->set_charset("UTF8");
            }

            //SELECT文の実行
            $sql = "SELECT product_name, price FROM product WHERE price <= 100";
            if ($result = $db->query($sql)){
                //連想配列を取得
                foreach ($result as $row){
                    echo $row["product_name"] . $row["price"] . "<br>";
                }
                //結果セットを閉じる
                $result->close();
            }
            $db->close();
        ?>
    </body>
</html>