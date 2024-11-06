<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TRY37</title>
    </head>
    <body>
        <?php
            //データベースへ接続
            $db = new mysqli('localhost', 'xb513874_cs97i', 'tu94ydpz6v', 'xb513874_joa6m');
            if ($db->connect_error){
                echo $db->connect_error;
                exit();
            }else{
                printf("データベースの接続に成功しました。");
            }
            $db->close();
        ?>
    </body>
</html>