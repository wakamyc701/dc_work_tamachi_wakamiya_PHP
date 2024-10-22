<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK12</title>
    </head>
    <body>
        <?php
            print '<p>課題1</p>';
            $i = 1;
            while($i<=100){
                if ($i % 12 == 0){
                    print '<p>Fizz Buzz</p>';
                } elseif ($i % 3 == 0){
                    print '<p>Fizz</p>';
                } elseif ($i % 4 == 0){
                    print '<p>Buzz</p>';
                } else {
                    print '<p>'.$i.'</p>';
                }
                $i++;
            }

            print '<p>課題2</p>';
            $j = 1;
            while ($j <= 9){
                $k = 1;
                while($k <= 9){
                    print '<p>'.$j.'*'.$k.'='.$j*$k.'</p>';
                    $k++;
                }
                $j++;
            }

            print '<p>課題3</p>';
            $l = 1;
            while($l<=10){
                $m = 1;
                print '<p>';
                while($m<=$l){
                    print '*';
                    $m++;
                }
                print '</p>';
                if ($l<10){
                    print '<p>!</p>';
                }
                $l++;
            }
        ?>
    </body>
</html>