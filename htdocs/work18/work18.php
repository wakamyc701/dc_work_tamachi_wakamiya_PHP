<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK18</title>
    </head>
    <body>
        <?php
            define('MAX','3'); // 1ページの表示数
 
            $customers = array( // 表示データの配列
                array('name' => '佐藤', 'age' => '10'),
                array('name' => '鈴木', 'age' => '15'),
                array('name' => '高橋', 'age' => '20'),
                array('name' => '田中', 'age' => '25'),
                array('name' => '伊藤', 'age' => '30'),
                array('name' => '渡辺', 'age' => '35'),
                array('name' => '山本', 'age' => '40'),
            );
            
            $customers_num = count($customers); // トータルデータ件数
 
            $max_page = ceil($customers_num / MAX); // トータルページ数

            // データ表示、ページネーションを実装
            if (isset($_GET['paged'])){
                $page_now = $_GET['paged'];
            } else {
                $page_now = 1;
            }
        ?>

        <table border="1">
            <tr>
                <th>名前</th>
                <th>年齢</th>
            </tr>
            <?php for ($i = ($page_now - 1) * MAX; $i < $page_now * MAX ; $i++){
                if ($i == $customers_num) break; ?>
                <tr>
                    <td><?php print $customers[$i]['name']; ?></td>
                    <td><?php print $customers[$i]['age']; ?></td>
                </tr>
            <?php } ?>
        </table>

        <?php for ($j = 1; $j <= $max_page; $j++){
            print '<a href="https://portfolio02.dc-itex.com/tamachi/0001/work18/work18.php?paged='.$j.'">'.$j.'</a>  ';
        }
        ?>
    </body>
</html>