<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <?php
        include_once ('../../include/view/ec_style.php');
        ?>
        <title>ECサイト ユーザー登録ページ</title>
    </head>
    <body>
        <?php
        include_once ('../../include/view/ec_header.php');
        ?>

        <main>
            <h2 class="title">ユーザー登録</h2>
            <?php
            include_once('../../include/view/ec_err_msg.php');
            include_once('../../include/view/ec_form.php');
            ?>
            <a href="index.php">ログインページへ</a>
        </main>
    </body>
</html>