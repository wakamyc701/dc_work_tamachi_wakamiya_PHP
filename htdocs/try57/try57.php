<?php
    require_once '../../include/model/try57_model.php';

    $product_data = [];
    $pdo = get_connection();
    $product_data = get_product_list($pdo);
    $product_data = h_array($product_data);

    include_once '../../include/view/try57_view.php';