<?php
include 'include/detailproduct.php';
include 'include/db.php';

if (isset($_GET['actiona'])) {
    include 'include/db.php';
    $pro_id = $_GET['pro_id'];
    $q = "
					SELECT * FROM `product` WHERE product_id = $pro_id
					";
    $result = $GLOBALS['db']->query($q);
    $row = $result->fetch(PDO::FETCH_ASSOC);

    if (isset($_GET['pro_id'])) {

        $pro_id = $row['product_id'];
        $quantity = 1;
        $op = true;
        $pro_name = $row['product_name'];
        $total = $row['product_price'];
        $pro_img = $row['product_img'];
        $pro_price = $row['product_price'];

        $product = array
            (
            "cart_id" => "$pro_id",
            "total" => "$total",
            "quantity" => "$quantity",
            "pro_id" => "$pro_id",
            "pro_name" => "$pro_name",
            "pro_price" => "$pro_price",
            "pro_img" => "$pro_img",
        );

        foreach ($_SESSION['Cart'] as $key => $value) {
            if ($value["pro_id"] == $pro_id) {
                $_SESSION['Cart'][$key]['quantity'] = $value["quantity"] += 1;
                $_SESSION['Cart'][$key]['total'] = $value['pro_price'] *= $value["quantity"];
                $op = false;
            }
        }

        if ($op) {
            array_push($_SESSION['Cart'], $product);
        }
    }
}
