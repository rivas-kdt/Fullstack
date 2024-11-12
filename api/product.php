<?php
include '../db.php';
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        if (isset($_GET['ID'])) {
            $ID = $_GET['ID'];
            $result = $conn->query("SELECT * FROM product p JOIN category c ON c.cat_id=prod_cat WHERE prod_id=$ID");
            $data = $result->fetch_assoc();
            echo json_encode($data);
        } 
        else if (isset($_GET['s'])) {
            $product = $_GET['s'];
            $result = $conn->query("SELECT * FROM product HAVING prod_name LIKE '%$product%' ");
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
            echo json_encode($products);
        }
        else if (isset($_GET['category'])) {
            $category = $_GET['category'];
            $result = $conn->query("SELECT * FROM product p JOIN category c ON c.cat_id=p.prod_cat HAVING cat_name LIKE '%$category%'");
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
            echo json_encode($products);
        }
        else {
            $result = $conn->query("SELECT * FROM product p JOIN category c ON c.cat_id=prod_cat");
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
            echo json_encode($products);
        }
        break;

    case 'POST':
        $prod_name = $input['prod_name'];
        $prod_cat = $input['prod_cat'];
        $prod_desc = $input['prod_desc'];
        $prod_price = $input['prod_price'];
        $conn->query("INSERT INTO product (prod_name, prod_cat, prod_desc, prod_price) VALUES ('$prod_name', $prod_cat, '$prod_desc', $prod_price)");
        echo json_encode(["message" => "Product added successfully"]);
        break;
    
    default:
        echo json_encode(["message" => "Invalid request method"]);
        break;
    }
$conn->close();
?>