<?php
    function get_connection() {
        try{
            $pdo=new PDO('mysql:host=localhost;dbname=xb513874_joa6m','xb513874_cs97i','tu94ydpz6v');
        } catch (PDOException $e){
            echo $e->getMessage();
            exit();
        }
        return $pdo;
    }

    function get_sql_result($pdo, $sql){
        $data = [];
        if($result=$pdo->query($sql)){
            if($result->rowCount()>0){
                while($row=$result->fetch()){
                    $data[]=$row;
                }
            }
        }
        return $data;
    }

    function get_product_list($pdo){
        $sql = 'SELECT product_name, price FROM product';
        return get_sql_result($pdo,$sql);
    }

    function h($str){
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }

    function h_array($array){
        foreach($array as $keys => $values) {
            foreach ($values as $key => $value) {
                $array[$keys][$key] = h($value);
            }
        }
        return $array;
    }