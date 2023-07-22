<?php
// Set the content type to JSON
header('content-type:application/json');

// Include the database connection and functions files
require('../../configs/connection.php');
require('../../configs/functions.php');

// Set the timezone to Asia/Kolkata
date_default_timezone_set("Asia/Kolkata");

// Get the current date and time
$date = date('Y-m-d');

// check if the `role` parameter is set in the query string
if (isset($_GET['employee_type'])) {
    $role = $_GET['employee_type'];
    $rquery = " AND e.employee_type = '$role'";
}else{
    $rquery = '';
}

// check if the `uid` parameter is set in the query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $uquery = " AND id = '$id'";
}else{
    $uquery = '';
}

// Check if the 'pquery' parameter is set in the query string
if (isset($_GET['pquery'])) {
    $pquery = '%'.$_GET['pquery'].'%';
}else{
    $pquery = '';
}

// Initialize an array to store the results
$results = [];

// Prepare the SELECT query
$query = "SELECT e.id, e.first_name, e.last_name, e.email, e.phone_number, pos.title AS position, et.employment_type AS employee_type
FROM employee e
JOIN positions pos ON e.position_id = pos.id LEFT JOIN employee_types et ON e.employee_type = et.id
";

// bind query to search
if ($pquery !== '') {
    $query .= " WHERE `e`.`id` LIKE ? OR `e`.`phone_number` LIKE ? OR `e`.`first_name` LIKE ? OR `e`.`email` LIKE ?";
    // Get the total number of records from our table "users".
    $total_pages = $con->query("SELECT COUNT(*) FROM employee e WHERE WHERE `e`.`id` LIKE ".$pquery." OR `e`.`phone_number` LIKE ".$pquery." OR `e`.`first_name` LIKE ".$pquery." OR `e`.`email` LIKE ".$pquery."") ->fetch_row()[0];
}else{
    $total_pages = $con->query('SELECT COUNT(*) FROM employee')->fetch_row()[0];
}
// Add UID to query
if($uquery !== ''){
$query .= $uquery;
$total_pages = '1';
}
// Add ROLE to query
if($rquery !== ''){
$query .= $rquery;
$total_pages = $con->query("SELECT COUNT(*) FROM employee WHERE `employee`.`employee_type`='$role'")->fetch_row()[0];
}

// Add an ORDER BY clause to sort the results by the added_on field
$query .= " ORDER BY e.added_on LIMIT ?,?";

// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Number of results to show on each page.
$num_results_on_page = 10;

// total number of pages.
$total_pages_no = ceil($total_pages / $num_results_on_page);

// Calculate the page to get the results we need from our table.
$calc_page = ($page - 1) * $num_results_on_page;

// Prepare the statement
$stmt = mysqli_prepare($con, $query);

// Bind the input parameters if needed
if ($pquery !== '') {
    mysqli_stmt_bind_param($stmt, "ssssii", $pquery, $pquery, $pquery, $pquery, $calc_page, $num_results_on_page);
}else{
    mysqli_stmt_bind_param($stmt, "ii", $calc_page, $num_results_on_page);
}

// Execute the query
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);
if($result->num_rows > 0){
    // Fetch the rows
    while ($row = mysqli_fetch_assoc($result)) {
        $results[] = $row;
    }
}else{
    $results = ['status' => 'error', 'message' => 'No records found'];
}

// Close the statement
mysqli_stmt_close($stmt);

// Close the database connection
mysqli_close($con);

// Return the results as a JSON object
echo json_encode(['status' => 'success', 'data' => $results, 'total_pages' => $total_pages_no]);