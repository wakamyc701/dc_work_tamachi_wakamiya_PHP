<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <?php
        include_once ('../../include/view/ec_style.php');
        ?>
        <title>わぁ！菓子屋さん本舗｜トップページ</title>

    </head>
    <body>
        <?php
        include_once ('../../include/view/ec_header.php');
        ?>

        <main>
            <div class="wrapper_index">
                <h2 class="title">ログイン</h2>
                <?php
                include_once('../../include/view/ec_result_msg.php');
                include_once('../../include/view/ec_form.php');
                ?>
                <a href="registration.php">新規ユーザー登録はこちらから</a>
            </div>
        </main>
    </body>
    <?php
    include_once ('../../include/view/ec_form_check.php');
    ?>
</html>