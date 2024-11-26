<?php
    $dsn = 'mysql:host=localhost;dbname=xb513874_joa6m';
    $login_user = 'xb513874_cs97i';
    $password = 'tu94ydpz6v';
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>TRY48</title>
    </head>
    <body>
        <?php
            try{
                //データベースへ接続
                $db = new PDO($dsn,$login_user,$password);
                $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

                $db->beginTransaction();

                $sql = "UPDATE product SET price = ? WHERE product_id = ?";

                $stmt = $db->prepare($sql);

                $stmt->bindValue(1,170);
                $stmt->bindValue(2, 1);

                $stmt->execute();
                $row = $stmt->rowCount();
                echo $row.'件更新しました';
                $db->commit();
            } catch (PDOException $e){
                echo $e->getMessage();
                $db->rollBack();
            }
        ?>
    </body>
</html>
