<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <?php
        include_once ('../../include/view/ec_style.php');
        ?>
        <title>わぁ！菓子屋さん本舗｜ユーザー登録ページ</title>
    </head>
    <body>
        <?php
        include_once ('../../include/view/ec_header.php');
        ?>

        <main>
            <div class="wrapper_index">
                <h2 class="title">ユーザー登録</h2>
                <div class="caution_msg">
                    <p>ユーザー名は「5文字以上」かつ「半角英数字とアンダースコア（_）」のみ登録可能です。<br>
                    パスワードは「8文字以上」かつ「半角英数字とアンダースコア（_）」のみ登録可能です。</p>
                </div>
                <?php
                include_once('../../include/view/ec_result_msg.php');
                include_once('../../include/view/ec_form.php');
                ?>
                <a href="index.php">ログインページへ</a>
            </div>
        </main>
    </body>
    <?php
    include_once ('../../include/view/ec_form_check.php');
    ?>
</html>