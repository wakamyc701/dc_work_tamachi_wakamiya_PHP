<?php
    $post_title = '';
    if (isset($_POST['post_title'])) {
        $post_title = htmlspecialchars($_POST['post_title'],ENT_QUOTES, 'UTF-8');
    }
    $post_text = '';
    if (isset($_POST['post_text'])) {
        $post_text = htmlspecialchars($_POST['post_text'],ENT_QUOTES, 'UTF-8');
    }
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK19</title>
    </head>
    <body>
        <?php
            // 入力情報不足時の処理
        ?>
        <form method="post">
            タイトル<input type="text" name="post_title"><br>
            書き込み内容<input type="text" name="post_text"><br>
            <input type="submit" value="送信">
        </form>

        <?php
            $fp = fopen("file_write.txt","a+");
            // フォーム入力内容の書き込み
            // 入力内容不足の場合は書き込まない処理←入力内容不足の判定条件は？

            fwrite($fp, $post_title.'：'.$post_text."\n");  // 書き込み処理


            // ファイル内容の表示

            fclose($fp);
        ?>

    </body>
</html>