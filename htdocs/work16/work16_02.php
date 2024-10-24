<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK16</title>
    </head>
    <body>
        <div>入力内容の取得</div>
        <?php
            if (isset($_GET['display_text']) && $_GET['display_text'] != "") {
                print '<p>名前： ' . htmlspecialchars($_GET['display_text'] , ENT_QUOTES, 'UTF-8'). '</p>';
            } else {
                print '<p>名前が入力されていません</p>';
            }
            //チェックボックスの処理をここに
            if (isset($_GET['check'])) {
                $check = $_GET['check'];
                foreach($check as $checks){
                    print '<p>'.$checks.'</p>';
                }
            } else {
                print '<p>チェックが入っていません</p>';
            }
        ?>
    </body>
</html>