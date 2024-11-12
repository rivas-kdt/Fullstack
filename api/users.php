<?php
include '../db.php';

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        if (isset($_GET['ID'])) {
            $ID = $_GET['ID'];
            $result = $conn->query("SELECT * FROM customer WHERE cust_id=$ID");
            $data = $result->fetch_assoc();
            echo json_encode($data);
        } 
        else if (isset($_GET['customer'])) {
            $customer = $_GET['customer'];
            $result = $conn->query("SELECT * FROM customer HAVING cust_name LIKE '%$customer%' ");
            $customers = [];
            while ($row = $result->fetch_assoc()) {
                $customers[] = $row;
            }
            echo json_encode($customers);
        }
        else {
            $result = $conn->query("SELECT * FROM customer");
            $customers = [];
            while ($row = $result->fetch_assoc()) {
                $customers[] = $row;
            }
            echo json_encode($customers);
        }
        break;

    case 'POST':
        $cust_name = $input['cust_name'];
        $conn->query("INSERT INTO customer(cust_name) VALUES('$cust_name')");
        $result = $conn->query("SELECT cust_id, cust_name FROM customer ORDER BY cust_id DESC LIMIT 1");
        $row = $result->fetch_assoc();
        echo json_encode(["message" => $row]);
        break;
    
    default:
        echo json_encode(["message" => "Invalid request method"]);
        break;
    }
$conn->close();
?>