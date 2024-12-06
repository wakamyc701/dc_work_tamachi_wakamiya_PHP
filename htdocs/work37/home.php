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
    if (isset($_POST['password']) === TRUE) {
        $password = $_POST['password'];
    } else {
        $password = '';
    }

    try{
        function connect_db() { //データベースへ接続
            $db = new PDO(DSN,LOGIN_USER,PASSWORD);
            return $db;
        }

        $db = connect_db();
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        //ここでデータベース照合
        $select = "SELECT * FROM user_table WHERE user_id = '" . $user_id . "'";
        $stmt = $db->query($select);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        //var_dump($result);
        if(empty($result)){ //該当のuser_idが無い
            echo '<p>ログインに失敗しました</p>';
            exit();
        }
        if ($result['password'] != $password) { //該当のuser_idが有るが、パスワードが異なる
            echo '<p>ログインに失敗しました</p>';
            exit();
        }

        if($cookie_confirmation === 'checked') {    //Cookie保存
            setcookie('cookie_confirmation', $cookie_confirmation, $cookie_expiration);
            setcookie('user_id', $user_id, $cookie_expiration);
            setcookie('password', $password, $cookie_expiration);
        } else {    //Cookie削除
            setcookie('cookie_confirmation', '', time()-30);
            setcookie('user_id', '', time()-30);
            setcookie('password', '', time()-30);
        }
    } catch (PDOException $e){
        echo $e->getMessage();
        exit();
    }


?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK37</title>
    </head>
    <body>
        <p>ログイン（疑似的）が完了しました</p>
        <?php
            echo '<p>'.$result['user_name'].'さん、ようこそ！</p>';
        ?>
    </body>
</html>
