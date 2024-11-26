<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>TRY49</title>
    </head>
    <body>
        <?php
            output_function();
            output_function_num(10);
            $function_num = make_function_num(10);
            echo $function_num;

            function output_function(){
                echo "<p>引数：なし、返り血：なしの関数</p>";
            }
            function output_function_num($num){
                echo "<p>引数：".$num."、返り血：なしの関数</p>";
            }
            function make_function_num($num){
                $str = "<p>引数：".$num."、返り血：ありの関数</p>";
                return $str;
            }

        ?>
    </body>
</html>
