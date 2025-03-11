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
                    <p><label for="name_form">商品名　　：</label>
                    <input id="name_form" type="text" name="product_name" 
                    pattern="\S+" title="商品名を入力してください">
                    <span id="name_check_msg" class="red_text small_text">　商品名を入力してください</span></p>
                    <p><label for="price_form">価格　　　：</label>
                    <input id="price_form" type="text" name="price" 
                    pattern="^[0-9０-９]+$" title="0以上の整数を入力してください">
                    <span id="price_check_msg" class="red_text small_text">　0以上の整数を入力してください</span></p>
                    <p><label for="stock_form">在庫数　　：</label>
                    <input id="stock_form" type="text" name="stock_qty" 
                    pattern="^[0-9０-９]+$" title="0以上の整数を入力してください">
                    <span id="stock_check_msg" class="red_text small_text">　0以上の整数を入力してください</span></p>
                    <p><label for="file_btn">商品画像　：</label>
                    <input id="file_btn" class="file_btn" type="file" name="upload_image" 
                    accept="image/png, image/jpeg" required>
                    <span id="file_check_msg" class="red_text small_text">JPEGまたはPNG形式のファイルを選択してください</span></p>
                    <p>公開フラグ：
                    <input type="radio" id="choice1" name="public_fig" value="1" checked />
                    <label for="choice1">公開</label>
                    <input type="radio" id="choice0" name="public_fig" value="0" />
                    <label for="choice0">非公開</label></p>
                    <button id="form_btn" disabled="true">商品を登録</button>
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
    <?php
    include_once ('../../include/view/ec_manage_check.php');
    ?>

</html>