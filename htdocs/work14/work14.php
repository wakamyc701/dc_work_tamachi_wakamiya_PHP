<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK14</title>
    </head>
    <body>
        <?php
            $num = array();

            for ($i=0; $i < 5; $i++) { 
                $random = rand(1,100);
                array_push($num,$random);
            }

            for ($j=0; $j < 5; $j++){
                if ($num[$j] % 2 == 0){
                    print '<p>'.$num[$j].'（偶数）</p>';
                } else {
                    print '<p>'.$num[$j].'（奇数）</p>';
                }
            }
        ?>
    </body>
</html>