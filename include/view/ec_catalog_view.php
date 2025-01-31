<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <?php
        include_once ('../../include/view/ec_style.php');
        ?>
        <title>わぁ！菓子屋さん本舗｜商品一覧ページ</title>
    </head>
    <body>
        <?php
        include_once ('../../include/view/ec_header.php');
        ?>

        <main>
            <div class="wrapper_main">
                <h2 class="title">商品一覧</h2>
                <?php
                include_once('../../include/view/ec_result_msg.php');
                get_list_catalog($db);
                ?>
            </div>
        </main>
    </body>
</html>