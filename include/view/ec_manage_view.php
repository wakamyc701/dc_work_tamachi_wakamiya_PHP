<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <?php
        include_once ('../../include/view/ec_style.php');
        ?>
        <title>わぁ！菓子屋さん本舗｜商品管理ページ</title>
    </head>
    <body>
        <?php
        include_once ('../../include/view/ec_header.php');
        ?>

        <main>
            <div class="wrapper_main">
                <h2 class="title">商品管理</h2>

                <?php
                include_once('../../include/view/ec_result_msg.php');
                ?>

                <form class="align_left" method="post" enctype="multipart/form-data" id="manage">
                    <input type="hidden" name="post_form" value="registration">
                    <p>商品名　　：<input type="text" name="product_name"></p>
                    <p>価格　　　：<input type="text" name="price"></p>
                    <p>在庫数　　：<input type="text" name="stock_qty"></p>
                    <p>商品画像　：<input class="file_btn" type="file" name="upload_image"></p>
                    <p>公開フラグ：<input type="radio" id="choice1" name="public_fig" value="1" />
                    <label for="choice1">公開</label>
                    <input type="radio" id="choice0" name="public_fig" value="0" />
                    <label for="choice0">非公開</label></p>
                    <button>商品を登録</button>
                </form>

                <table class="product_list">
                    <tr>
                        <th>商品画像</th>
                        <th>商品名</th>
                        <th>価格</th>
                        <th>在庫数</th>
                        <th>公開フラグ</th>
                        <th>削除</th>
                    </tr>
                    <?php
                    get_list_manage($db);
                    ?>
                </table>
            </div>
        </main>
    </body>
</html>