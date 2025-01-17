<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <?php
        include_once ('../../include/view/ec_style.php');
        ?>
        <title>ECサイト 商品管理ページ</title>
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

                <form class="align-left" method="post" enctype="multipart/form-data" id="manage">
                    <input type="hidden" name="post_form" value="registration">
                    <p>商品名　　：<input type="text" name="product_name"></p>
                    <p>価格　　　：<input type="text" name="price"></p>
                    <p>在庫数　　：<input type="text" name="stock_qty"></p>
                    <p>商品画像　：<input type="file" name="upload_image"></p>
                    <p>公開フラグ：<input type="radio" id="choice0" name="public_fig" value="0" /><label for="choice0">公開</label>
                        <input type="radio" id="choice1" name="public_fig" value="1" /><label for="choice1">非公開</label></p>
                    <input type="submit" value="商品を登録">
                </form>

                <form method="post" id="change_stock">
                    <input type="hidden" name="post_form" value="change_stock">
                </form>

                <input type="submit" form="change_stock" value="在庫数変更">

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
                    //$result = get_list_manage($db);
                    //var_dump($result);
                    /*
                    foreach($result as $row) {
                        echo '<tr>
                            <td><a href="../ec_site/img/' . $row['image_name'] . '" target="_blank"><img src="../ec_site/img/' . $row['image_name'] . '"></a></td>
                            <td>' . $row['product_name'] . '</td>
                            <td>' . $row['price'] . '</td>
                            <td>' . $row['stock_qty'] . '</td>
                            <td>' . $row['public_flg'] . '</td>
                            <td></td>
                        </tr>';
                    }
                    */
                    ?>
                </table>

            </div>
        </main>
    </body>
</html>