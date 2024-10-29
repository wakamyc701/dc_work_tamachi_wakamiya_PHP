<?php
    $post_title;
    if (isset($_POST['post_title'])) {
        $post_title = htmlspecialchars($_POST['post_title'],ENT_QUOTES, 'UTF-8');
    }
    $post_text;
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
        <form method="post">
            タイトル<input type="text" name="post_title"><br>
            書き込み内容<input type="text" name="post_text"><br>
            <input type="submit" value="送信">

            <?php
                $fp = fopen("file_write.txt","a+");
                
                // フォーム入力内容の書き込み
                // 書き込み処理、入力内容不足の場合は書き込まない処理
                if ((isset($_POST['post_title'])) && ($_POST['post_title'] != "") && (isset($_POST['post_text'])) && ($_POST['post_text'] != "")){
                    fwrite($fp, $post_title."：".$post_text."\n");  // ファイルポインタは末尾
                } else {
                    print '入力情報が不足しています';
                }

                // ファイル内容の読み込みと表示

                fseek($fp, 0);  //ファイルポインタを先頭に

                $l_array = array();
                $i = 0;
                while ($line = fgets($fp)) {
                    array_push($l_array, $line);
                    //print "$line<br>";
                    $i++;
                }

                print "<p>";
                for ($j = $i - 1 ; $j >= 0; $j--) {
                    print "$l_array[$j]<br>";
                }
                print "</p>";

                fclose($fp);
            ?>
        </form>
    </body>
</html>