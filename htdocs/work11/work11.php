<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK11</title>
    </head>
    <body>
        <?php
            print '<p>課題1</p>';
            for ($i=1; $i<=100; $i++):
                if ($i % 12 == 0):
                    print '<p>Fizz Buzz</p>';
                elseif ($i % 3 == 0):
                    print '<p>Fizz</p>';
                elseif ($i % 4 == 0):
                    print '<p>Buzz</p>';
                else:
                    print '<p>'.$i.'</p>';
                endif;
            endfor;

            print '<p>課題2</p>';
            for ($j=1; $j<=9; $j++):
                for ($k=1; $k<=9; $k++):
                    print '<p>'.$j.'*'.$k.'='.$j*$k.'</p>';
                endfor;
            endfor;

            print '<p>課題3</p>';
            for ($l=1; $l<=10; $l++):
                print '<p>';
                for ($m=1; $m<=$l; $m++):
                    print '*';
                endfor;
                print '</p>';
                if ($l<10):
                    print '<p>!</p>';
                endif;
            endfor;
        ?>
    </body>
</html>