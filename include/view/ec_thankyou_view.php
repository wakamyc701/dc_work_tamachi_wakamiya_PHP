<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <?php
        include_once ('../../include/view/ec_style.php');
        ?>
        <title>ECサイト 購入完了ページ</title>
    </head>
    <body>
        <?php
        include_once ('../../include/view/ec_header.php');
        ?>

        <main>
            <div class="wrapper_middle">
                <?php
                suc_msg('ご注文を承りました。お買い上げありがとうございます！');
                include_once('../../include/view/ec_result_msg.php');
                get_list_thankyou($db);
                echo '<p class="purple_text subtotal">小計：　' . $_SESSION['price_sum'] . '円</p>';
                ?>
            </div>
        </main>
    </body>
</html>