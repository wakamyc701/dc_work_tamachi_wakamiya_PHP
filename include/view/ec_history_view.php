<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <?php
        include_once ('../../include/view/ec_style.php');
        ?>
        <title>ECサイト 購入履歴ページ</title>
    </head>
    <body>
        <?php
        include_once ('../../include/view/ec_header.php');
        ?>

        <main>
            <div class="wrapper_main">
                <h2 class="title">購入履歴</h2>
                <?php
                include_once('../../include/view/ec_result_msg.php');
                get_list_history($db);
                ?>
            </div>
        </main>
    </body>
</html>