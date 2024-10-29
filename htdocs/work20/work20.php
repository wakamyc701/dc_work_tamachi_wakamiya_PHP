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
        <title>WORK20</title>
    </head>
    <body>
        <!--<form method="post" action="image_save.php" enctype="multipart/form-data">-->
        <form method="post" enctype="multipart/form-data">
            <p>タイトル：<input type="text" name="post_title"></p>
            <p>書き込み内容：<input type="text" name="post_text"></p>
            <p><input type="file" name="upload_image"></p>
            <input type="submit" value="送信">

            <?php
                //入力情報不足時の処理
                if ((!isset($_POST['post_title'])) || ($_POST['post_title'] == "") || (!isset($_POST['post_text'])) || ($_POST['post_text'] == "") || (!isset($_FILES['upload_image']))){
                    print '入力情報が不足しています';
                    exit;
                }

                //画像アップロード
                $save = 'img/' . basename($_FILES['upload_image']['name']);

                if(move_uploaded_file($_FILES['upload_image']['tmp_name'],$save)){
                    echo 'アップロード成功しました。';
                } else {
                    echo 'アップロード失敗しました。';
                }
    
                $fp = fopen("file_write.txt","a+");
                
                // フォーム入力内容の書き込み
                fwrite($fp, $post_title."\t".$post_text."\n");  // ファイルポインタは末尾

                // ファイル内容の読み込みと表示

                fseek($fp, 0);  //ファイルポインタを先頭に

                $l_array = array();
                $i = 0;
                while ($line = fgets($fp)) {
                    $strs = explode("\t", $line);
                    array_unshift($l_array, [$strs[0],$strs[1]]);
                    //print "$line<br>";
                    $i++;
                }

                print "<p>";
                for ($j = 0 ; $j < $i; $j++) {
                    print $l_array[$j][0]."：".$l_array[$j][1]."<br>";
                }
                print "</p>";

                fclose($fp);
            ?>
        </form>
    </body>
</html>