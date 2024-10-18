<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK06</title>
    </head>
    <body>
        <?php
            $random00 = rand(1,100);
            print '<p>$random00: '.$random00.'</p>';
            if ($random00 % 6 == 0) :
                print '<p>3と6の倍数です</p>';
            elseif ($random00 % 3 == 0) :
                print '<p>3の倍数で、6の倍数ではありません</p>';
            else:
                print '<p>倍数ではありません。</p>';
            endif;

            $random01 = rand(1,10);
            $random02 = rand(1,10);
            print '<p>random01 = '.$random01.', random02 = '.$random02.' です。';

            if ($random01 > $random02) :
                print 'random01の方が大きいです。';
            elseif ($random01 < $random02) :
                print 'random02の方が大きいです。';
            else :
                print '2つは同じ数です。';
            endif;

            $cnt = 0;
            if ($random01 % 3 == 0) :
                $cnt++;
            endif;
            if ($random02 % 3 == 0) :
                $cnt++;
            endif;

            if ($cnt == 0) :
                print '2つの数字の中に3の倍数が含まれていません';
            else:
                print '2つの数字の中には3の倍数が'.$cnt.'つ含まれています。';
            endif;
            print '</p>';

        ?>
    </body>
</html>