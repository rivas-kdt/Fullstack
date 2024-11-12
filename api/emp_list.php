<?php
include('../db.php');
header("Content-Type: application/json");

// Add CORS headers
header("Access-Control-Allow-Origin: http://localhost:3001"); // Allow your frontend origin
header("Access-Control-Allow-Methods: GET, OPTIONS"); // Allow GET and OPTIONS methods
header("Access-Control-Allow-Headers: Content-Type"); // Allow specific headers

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        if (isset($_GET['ID'])) {
            $ID = $_GET['ID'];
            $result = $conn->query("SELECT * FROM kdtphdb.emp_prof e JOIN kdtphdb.kdtbu d ON e.fldGroup=d.fldBU JOIN kdtphdb.kdtpositions p ON e.fldDesig=p.fldAcro WHERE fldEmployeeNum=$ID");
            $data = $result->fetch_assoc();
            echo json_encode($data);
        } else {
            $result = $conn->query("SELECT * FROM kdtphdb.emp_prof");
            $employee = [];
            while ($row = $result->fetch_assoc()) {
                $employee[] = $row;
            }
            echo json_encode($employee);
        }
        break;
    default:
        echo "awit";
        break;
}
