<?php
    $dsn = 'mysql:host=localhost;dbname=xb513874_joa6m';
    $login_user = 'xb513874_cs97i';
    $password = 'tu94ydpz6v';
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK32</title>
    </head>
    <body>
        <?php
            try{
                //データベースへ接続
                $db = new PDO($dsn,$login_user,$password);
                $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

                $db->beginTransaction();

                $sql = "UPDATE product SET price = 160 WHERE product_id = 1";
                $result = $dd->query($sql);
                $row = $result->rowCount();
                echo $row.'件更新しました。';
                $db->commit();
            } catch (PDOException $e){
                echo $e->getMessage();
                $db->rollBack();
            }
        ?>
    </body>
</html>
