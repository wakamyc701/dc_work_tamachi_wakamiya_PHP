<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>WORK15</title>
    </head>
    <body>
        <?php
            $class01 = [
                ['tokugawa',rand(1,100)],
                ['oda',rand(1,100)],
                ['toyotomi',rand(1,100)],
                ['takeda',rand(1,100)],
            ];

            $class02 = [
                ['minamoto',rand(1,100)],
                ['tairaa',rand(1,100)],
                ['sugawara',rand(1,100)],
                ['fujiwara',rand(1,100)],
            ];

            $school = array($class01,$class02);
        ?>
        <pre>
            <?php
                print_r($school);

                print '<p>odaさんの点数は'.$school[0][1][1].'点</p>';
                print '<p>sugawaraさんの点数は'.$school[1][2][1].'点</p>';

                if ($school[0][1][1] > $school[1][2][1]):
                    print '<p>odaさんの点数はsugawaraさんの点数より高いです。</p>';
                elseif ($school[0][1][1] < $school[1][2][1]):
                    print '<p>sugawaraさんの点数はodaさんの点数より高いです。</p>';
                endif;

                $sum1 = 0;
                for ($i=0; $i < 4; $i++):
                    $sum1 += $school[0][$i][1];
                endfor;
                $ave1 = $sum1 / 4;

                $sum2 = 0;
                for ($j=0; $j < 4; $j++):
                    $sum2 += $school[1][$j][1];
                endfor;
                $ave2 = $sum2 / 4;

                print '<p>class01の平均点は'.$ave1.'点</p>';
                print '<p>class02の平均点は'.$ave2.'点</p>';
            ?>
        </pre>
    </body>
</html>