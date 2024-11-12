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
        if (isset($_GET['ID']) && isset($_GET['YR'])) {
            $ID = $_GET['ID'];
            $YR = $_GET['YR'];
            $result = $conn->query("SELECT DATE_FORMAT(l_sdate, '%b %y') AS month, l_id, l_eid, l_ename, l_file, CASE WHEN l_sdate != l_edate THEN CONCAT_WS(' - ', DATE_FORMAT(l_sdate, '%c/%d'), DATE_FORMAT(l_edate, '%c/%d')) ELSE DATE_FORMAT(l_edate, '%c/%d') END AS leave_date, l_type, l_reason, fldAccept, CASE WHEN l_dtype != 0 THEN 0.5 WHEN l_sdate = l_edate THEN 1 ELSE DATEDIFF(l_edate, l_sdate) + 1 END AS used, l_dtype FROM formsdb.leave_info i JOIN formsdb.leave_accept a ON i.l_id = a.fldLeaveId JOIN kdtphdb.emp_prof e ON a.fldEmployeeNum = e.fldEmployeeNum WHERE l_sdate BETWEEN '" . ($YR - 1) . "-12-01' AND '" . $YR . "-12-31' AND l_eid = $ID GROUP BY l_id");
            $leave_info = [];
            while ($row = $result->fetch_assoc()) {
                $leave_info[] = $row;
            }
            echo json_encode($leave_info);
        }
        break;
    default:
        echo "PLEASE SELECT A METHOD";
        break;
}
