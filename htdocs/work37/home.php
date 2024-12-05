<?php
    define('DSN','mysql:host=localhost;dbname=xb513874_joa6m');
    define('LOGIN_USER','xb513874_cs97i');
    define('PASSWORD','tu94ydpz6v');
    define('DB_TABLE','user_table');

    define('EXPIRATION_PERIOD', 30);
    $cookie_expiration = time() + EXPIRATION_PERIOD * 60 * 24 * 365;

    if(isset($_POST['cookie_confirmation']) === TRUE) {
        $cookie_confirmation = $_POST['cookie_confirmation'];
    } else {
        $cookie_confirmation = '';
    }
    if (isset($_POST['user_id']) === TRUE) {
        $user_id = $_POST['user_id'];
    } else {
        $user_id = '';
    }

    if($cookie_confirmation === 'checked') {
        setcookie('cookie_confirmation', $cookie_confirmation, $cookie_expiration);
        setcookie('user_id', $user_id, $cookie_expiration);
    } else {
        setcookie('cookie_confirmation', '', time()-30);
        setcookie('user_id', '', time()-30);
    }
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK37</title>
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

        <p>ログイン（疑似的）が完了しました</p>
    </body>
</html>
