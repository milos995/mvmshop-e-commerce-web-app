<?php
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
 
include_once 'init.php';

if(isset($_GET['cat_id'])){
    $cat_id = $_GET['cat_id'];
}else{
    die();
}
 
$sql = "SELECT * FROM products WHERE categories = '$cat_id'";
$results = $db->query($sql);
 
if(mysqli_num_rows($results)>0){
 
    // products array
    $products_arr=array();
    $products_arr["results"]=array();
 
    while ($product = mysqli_fetch_assoc($results)){
        $product_item=array(
            "id" => $product['id'],
            "title" => $product['title'],
            "price" => $product['price'],
            "list_price" => $product['list_price'],
            "brand" => $product['brand'],
            "categories" => $product['categories'],
            "image" => $product['image'],
            "description" => $product['description'],
            "featured" => $product['featured'],
            "sizes" => $product['sizes']
        );
 
        array_push($products_arr["results"], $product_item);
    }
 
    echo json_encode($products_arr);
}
 
else{
    echo json_encode(
        array("message" => "Nije pronadjen ni jedan proizvod.")
    );
}
?>