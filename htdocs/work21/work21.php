<?php
    $check_data1 = '';
    if (isset($_POST['check_data1'])){
        $check_data1 = htmlspecialchars($_POST['check_data1'],ENT_QUOTES,'UTF-8');
    }
    $check_data2 = '';
    if (isset($_POST['check_data2'])){
        $check_data2 = htmlspecialchars($_POST['check_data2'],ENT_QUOTES,'UTF-8');
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>WORK21</title>
    </head>
    <body>
        <form method="post">
            <div>半角アルファベットの大文字と小文字のみ入力してください。</div>
            <input type="text" name="check_data1" value=<?php echo $check_data1 ?>>
            <?php
                if (!preg_match("/^[a-zA-Z]+$/", $check_data1) && $check_data1 !== ''){
                    echo "<div>正しい入力形式ではありません</div>";
                }
                if (preg_match("/^.*[d]+[c]+.*$/", $check_data1)){
                    echo "<div>ディーキャリアが含まれています</div>";
                }
                if (preg_match("/^.*[e]+[n]{1}[d]{1}$/", $check_data1)){
                    echo "<div>終了です！</div>";
                }
        ?>
            <div>携帯電話番号を半角+ハイフン付きで入力してください。</div>
            <input type="text" name="check_data2" value=<?php echo $check_data2 ?>>
            <input type="submit" value="送信">
        <?php
            if (!preg_match("/^[0]{1}[789]{1}[0]{1}[-]{1}[0-9]{4}[-]{1}[0-9]{4}$/", $check_data2) && $check_data2 !== ''){
                echo "<div>携帯電話番号の形式ではありません</div>";
            }
        ?>
        </form>
    </body>
</html>