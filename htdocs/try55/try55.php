<?php
    session_start();
    if (isset($_SESSION['err_flg']) && $_SESSION['err_flg']) {
        echo "<p>ログインが失敗しました：正しいログインID（半角英数字）を入力してください。</p>";
    }

    $_SESSION['err_flg'] = false;

    if (isset($_POST['logout'])) {
        $session = session_name();
        $_SESSION = [];
        if (isset($_COOKIE[$session])){
            $params = session_get_cookie_params();
            setcookie($session, '', time()-30, '/');
            $message = "<p>ログアウトされました。</p>";
        }
    } else {
        if (isset($_SESSION['login_id'])) {
            header('Location: top.php');
            exit();
        }
    }

    if(isset($_COOKIE['cookie_confirmation']) === true) {
        $cookie_confirmation = "checked";
    } else {
        $cookie_confirmation = "";
    }
    if(isset($_COOKIE['login_id']) === true) {
        $login_id = $_COOKIE['login_id'];
    } else {
        $login_id = '';
    }
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>TRY55</title>
    </head>
    <body>
        <?php
            if(isset($message)){
                echo $message;
            }
        ?>
        <form action="top.php" method="post">
            <label for="login_id">ログインID</label><input type="text" id="login_id" name="login_id" value="<?php echo $login_id; ?>"><br>
            <input type="checkbox" name="cookie_confirmation" value="checked" <?php print $cookie_confirmation; ?>>次回からログインIDの入力を省略する<br>
            <input type="submit" value="ログイン">
        </form>
    </body>
</html>
