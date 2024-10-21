<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK09</title>
    </head>
    <body>
        <?php
            $random00 = rand(1,100);
        ?>
        <p>$random00: <?php print $random00 ?></p>
        <?php switch($random00 % 6) :
            case 0:
        ?>
                <p>3と6の倍数です</p>
        <?php
                break;
            default:
                switch ($random00 % 3):
                    case 0:
        ?>
                        <p>3の倍数で、6の倍数ではありません</p>
        <?php
                        break;
                    default:
        ?>
                        <p>倍数ではありません。</p>
        <?php
                    endswitch;
            endswitch;
        ?>

        <?php
            $random01 = rand(1,10);
            $random02 = rand(1,10);
        ?>
        <p>random01 = <?php print $random01 ?>, random02 = <?php print $random02 ?> です。</p>
        <?php
            switch(true):
                case($random01 > $random02):
        ?>
                    <p>random01の方が大きいです。</p>
        <?php
                    break;
                case($random01 < $random02):
        ?>
                    <p>random02の方が大きいです。</p>
        <?php
                    break;
                default:
        ?>
                    <p>2つは同じ数です。</p>
        <?php endswitch; ?>

        <?php
            $cnt = 0;
            switch($random01 % 3):
                case 0:
                    $cnt++;
            endswitch;
            switch($random02 % 3):
                case 0:
                    $cnt++;
            endswitch;
        ?>

        <?php
            switch($cnt):
                case 0:
        ?>
                    <p>2つの数字の中に3の倍数が含まれていません</p>
        <?php
                    break;
                default:
        ?>
                    <p>2つの数字の中には3の倍数が<?php print $cnt ?>つ含まれています。</p>
        <?php endswitch; ?>
        </p>

    </body>
</html>