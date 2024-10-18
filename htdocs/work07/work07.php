<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK07</title>
    </head>
    <body>
        <?php
            $random00 = rand(1,100);
        ?>
        <p>$random00: <?php print $random00 ?></p>
        <?php if ($random00 % 6 == 0) : ?>
            <p>3と6の倍数です</p>
        <?php elseif ($random00 % 3 == 0) : ?>
            <p>3の倍数で、6の倍数ではありません</p>
        <?php else: ?>
            <p>倍数ではありません。</p>
        <?php endif; ?>

        <?php
            $random01 = rand(1,10);
            $random02 = rand(1,10);
        ?>
        <p>random01 = <?php print $random01 ?>, random02 = <?php print $random02 ?> です。
        <?php if ($random01 > $random02) : ?>
            random01の方が大きいです。
        <?php elseif ($random01 < $random02) : ?>
            random02の方が大きいです。
        <?php else : ?>
            2つは同じ数です。
        <?php endif; ?>

        <?php
            $cnt = 0;
            if ($random01 % 3 == 0) :
                $cnt++;
            endif;
            if ($random02 % 3 == 0) :
                $cnt++;
            endif;
        ?>

        <?php if ($cnt == 0) : ?>
            2つの数字の中に3の倍数が含まれていません
        <?php else: ?>
            2つの数字の中には3の倍数が<?php print $cnt ?>つ含まれています。
        <?php endif; ?>
        </p>

    </body>
</html>