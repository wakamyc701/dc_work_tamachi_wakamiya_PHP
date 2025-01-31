<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <?php
        include_once ('../../include/view/ec_style.php');
        ?>
        <title>わぁ！菓子屋さん本舗｜ショッピングカート</title>
    </head>
    <body>
        <?php
        include_once ('../../include/view/ec_header.php');
        ?>

        <main>
            <div class="wrapper_main">
                <h2 class="title">ショッピングカート</h2>
                <?php
                include_once('../../include/view/ec_result_msg.php');
                get_list_cart($db);
                ?>
            </div>
        </main>
    </body>
</html>