<?php
    if(isset($_COOKIE['cookie_confirmation']) === TRUE) {
        $cookie_confirmation = "CHECKED";
    } else {
        $cookie_confirmation = "";
    }
    if(isset($_COOKIE['user_id']) === TRUE) {
        $user_id = $_COOKIE['user_id'];
    } else {
        $user_id = '';
    }
    if(isset($_COOKIE['password']) === TRUE) {
        $password = $_COOKIE['password'];
    } else {
        $password = '';
    }
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK37 ログインページ</title>
    </head>
    <body>
        <form action="home.php" method="post">
            <p><label for="user_id">user_id:</label><input type="text" id="user_id" name="user_id" value="<?php echo $user_id; ?>"></p>
            <p><label for="password">password:</label><input type="text" id="password" name="password" value="<?php echo $password; ?>"></p>
            <p><input type="checkbox" name="cookie_confirmation" value="checked" <?php print $cookie_confirmation;?>>次回からログインIDの入力を省略する</p>
            <p><input type="submit" value="ログイン"></p>
        </form>
    </body>
</html>