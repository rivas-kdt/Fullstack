<?php
include('../db.php');
header("Content-Type: application/json");
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        $result = $conn->query("SELECT * FROM category");
        $category = [];
        while ($row = $result->fetch_assoc()) {
            $category[]=$row;
        }
        echo json_encode($category);
        break;
    default:
        echo "awit";
    break;
    }
?>