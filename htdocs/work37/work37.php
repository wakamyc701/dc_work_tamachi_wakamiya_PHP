<?php
    define('DSN','mysql:host=localhost;dbname=xb513874_joa6m');
    define('LOGIN_USER','xb513874_cs97i');
    define('PASSWORD','tu94ydpz6v');
    define('DB_TABLE','user_table');
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK37 ログインページ</title>
    </head>
    <body>
        <?php
            try{

                function connect_db() { //データベースへ接続
                    $db = new PDO(DSN,LOGIN_USER,PASSWORD);
                    return $db;
                }

                $db = connect_db();
                $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        
            } catch (PDOException $e){
                echo $e->getMessage();
                exit();
            }
        ?>

        <form action="home.php" method="post">
            <p><label for="user_id">user_id:</label><input type="text" id="user_id" name="user_id"></p>
            <p><label for="password">password:</label><input type="text" id="password" name="password"></p>
            <p><input type="checkbox" name="cookie_confirmation" value="checked" <?php print $cookie_confirmation;?>>次回からログインIDの入力を省略する</p>
            <p><input type="submit" value="ログイン"></p>
        </form>
    </body>
</html>