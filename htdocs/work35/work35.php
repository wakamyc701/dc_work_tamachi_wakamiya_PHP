<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK35</title>
    </head>
    <body>
        <?php
            $function_num = makenum();
            echo $function_num;

            function makenum(){
                $num = rand(1,10);
                if ($num % 2 == 0){
                    $num *= 10;
                } else {
                    $num *= 100;
                }
                return $num;
            }

        ?>
    </body>
</html>
