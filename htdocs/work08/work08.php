<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK08</title>
    </head>
    <body>
        <?php
            $random00 = rand(1,100);
            print '<p>$random00: '.$random00.'</p>';
            switch($random00 % 6){
                case 0:
                    print '<p>3と6の倍数です</p>';
                    break;
                default:
                    switch ($random00 % 3) {
                        case 0:
                            print '<p>3の倍数で、6の倍数ではありません</p>';
                            break;
                        default:
                            print '<p>倍数ではありません。</p>';
                        }
            }

            $random01 = rand(1,10);
            $random02 = rand(1,10);
            print '<p>random01 = '.$random01.', random02 = '.$random02.' です。';

            switch(true){
                case $random01 > $random02:
                    print 'random01の方が大きいです。';
                    break;
                case $random01 < $random02:
                    print 'random02の方が大きいです。';
                    break;
                default:
                    print '2つは同じ数です。';
            }

            $cnt = 0;
            switch($random01 % 3){
                case 0:
                    $cnt++;
            }
            switch($random02 % 3){
                case 0:
                    $cnt++;
            }

            switch($cnt){
                case 0:
                    print '2つの数字の中に3の倍数が含まれていません';
                    break;
                default:
                    print '2つの数字の中には3の倍数が'.$cnt.'つ含まれています。';
            }
            print '</p>';

        ?>
    </body>
</html>