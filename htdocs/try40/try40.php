<?php
    $host = 'localhost';
    $login_user = 'xb513874_cs97i';
    $password = 'tu94ydpz6v';
    $database = 'xb513874_joa6m';
    $error_msg = [];
    $product_name;
    $price;
    $price_val;
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>TRY40</title>
    </head>
    <body>
        <?php
            //データベースへ接続
            $db = new mysqli($host, $login_user, $password, $database);
            if ($db->connect_error){
                echo $db->connect_error;
                exit();
            }else{
                $db->set_charset("UTF8");
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['price'])) {
                    $price = $_POST['price'];
                }
                $db->begin_transaction();

                //UPDATE文の実行
                $update = "UPDATE product SET price =".$price." WHERE product_id = 1;";
                if($result = $db->query($update)) {
                    $row = $db->affected_rows;
                } else {
                    $error_msg[] = 'UPDATE実行エラー [実行SQL]' .$update;
                }
                //$error_msg[] = '強制的にエラーメッセージを挿入';

                //エラーメッセージ格納の有無によりトランザクションの成否を判定
                if (count($error_msg) == 0) {
                    echo $row.'件更新しました。';
                    $db->commit();
                } else {
                    echo '更新が失敗しました。';
                    $db->rollback();
                }
                //下記はエラー確認用。エラー確認が必要な際はコメントを外してください。
                //var_dump($error_msg);
            }

            //SELECT文の実行
            $select = "SELECT product_name, price FROM product WHERE product_id = 1";
            if ($result = $db->query($select)){
                //連想配列を取得
                while ($row = $result->fetch_assoc()){
                    $product_name = $row['product_name'];
                    $price = $row['price'];
                }
                //結果セットを閉じる
                $result->close();
            }
            if($price == 150) {
                $price_val = 130;
            } else {
                $price_val = 150;
            }

            $db->close();
        ?>

        <form method="post">
            <p><?php echo $product_name ?>の現在の価格は<?php echo $price ?>円です。</p>
            <input type="radio" name="price" value="<?php echo $price_val ?>" checked> <?php echo $price_val ?>円に変更する
            <input type="submit" value="送信">
        </form>
    </body>
</html>