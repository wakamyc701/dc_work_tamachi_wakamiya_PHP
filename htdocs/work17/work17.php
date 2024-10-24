<?php
    $display_text = '';
    if (isset($_POST['display_text'])) {
        $display_text = htmlspecialchars($_POST['display_text'],ENT_QUOTES, 'UTF-8');
    }
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK17</title>
    </head>
    <body>
        <div>フォーム</div>
        <form method="post">
            名前<input type="text" name="display_text"><br>
            選択肢01<input type="checkbox" name="check[]" value="選択肢01"><br>
            選択肢02<input type="checkbox" name="check[]" value="選択肢02"><br>
            選択肢03<input type="checkbox" name="check[]" value="選択肢03"><br>
            <input type="submit" value="送信">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST"):
            if (isset($_POST['display_text']) && $_POST['display_text'] != "") {
                print '<p>名前： ' . htmlspecialchars($_POST['display_text'] , ENT_QUOTES, 'UTF-8'). '</p>';
            } else {
                print '<p>名前が入力されていません</p>';
            }
            //チェックボックスの処理をここに
            if (isset($_POST['check'])) {
                $check = $_POST['check'];
                foreach($check as $checks){
                    print '<p>'.$checks.'</p>';
                }
            } else {
                print '<p>チェックが入っていません</p>';
            }
        endif;
        ?>

    </body>
</html>