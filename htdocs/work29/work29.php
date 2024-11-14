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
        <title>WORK29</title>
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

                $db->begin_transaction();

                if (isset($_POST['ins'])){
                    //INSERT文の実行
                    //echo 'INS';
                    $insert = "INSERT INTO product(
                        product_id,
                        product_code,
                        product_name,
                        price,
                        category_id
                    ) VALUES (
                        21,
                        1021,
                        'エシャロット',
                        200,
                        1
                    );";
                    if (!$db->query($insert)){
                        $error_msg[] = 'INSERT実行エラー [実行SQL]' .$insert;
                    }
                    //$error_msg[] = '強制的にエラーメッセージを挿入';

                } elseif (isset($_POST['del'])) {
                    //DELETE文の実行
                    //echo 'DEL';
                    $delete = "DELETE FROM product WHERE product_id = 21;";
                    if (!$db->query($delete)){
                        $error_msg[] = 'DELETE実行エラー [実行SQL]' .$delete;
                    }
                    //$error_msg[] = '強制的にエラーメッセージを挿入';

                }

                //エラーメッセージ格納の有無によりトランザクションの成否を判定
                if (count($error_msg) == 0) {
                    echo '更新しました。';
                    $db->commit();
                } else {
                    echo '更新が失敗しました。';
                    $db->rollback();
                }
                //下記はエラー確認用。エラー確認が必要な際はコメントを外してください。
                //var_dump($error_msg);
            }

            $db->close();
        ?>

        <form method="post">
            <input type="submit" name="ins" value="挿入">
            <input type="submit" name="del" value="削除">
        </form>
    </body>
</html>