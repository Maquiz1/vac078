<?php
include 'database_connection.php';



// Reading value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

$searchArray = array();

// Search
$searchQuery = " ";
if ($searchValue != '') {
    $searchQuery = " AND (user_email LIKE :user_email OR 
        user_name LIKE :user_name OR
        user_type LIKE :user_type OR 
        user_id LIKE :user_id ) ";
    $searchArray = array(
        'user_id'     => "%$searchValue%",
        'user_email'  => "%$searchValue%",
        'user_name'   => "%$searchValue%",
        'user_type'   => "%$searchValue%",
        'user_status' => "%$searchValue%"
    );
}

// Total number of records without filtering
$stmt = $connect->prepare("SELECT COUNT(*) AS allcount FROM user ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

// Total number of records with filtering
$stmt = $connect->prepare("SELECT COUNT(*) AS allcount FROM user WHERE 1 " . $searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

// Fetch records
$stmt = $connect->prepare("SELECT * FROM user WHERE 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset");

// Bind values
foreach ($searchArray as $key => $search) {
    $stmt->bindValue(':' . $key, $search, PDO::PARAM_STR);
}

$stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
$stmt->execute();
$empRecords = $stmt->fetchAll();

$data = array();

foreach ($empRecords as $row) {
    $status = ' ';

    if ($row['user_status'] == 'Active') {
        $status =  '<span class="label label-success">Active</span>';
    } else {
        $status =  '<span class="label label-danger">Inactive</span>';
    }

    $data[] = array(
        "user_id"     => $row['user_id'],
        "user_email"  => $row['user_email'],
        "user_status" => $row['user_status'],
        "user_name"   => $row['user_name'],
        "user_type"   => $row['user_type']
    );


    $sub_array = array();
    $sub_array[] = $row['user_id'];
    $sub_array[] = $row['user_email'];
    $sub_array[] = $row['user_name'];
    $sub_array[] = $row['user_type'];
    $sub_array[] = $status;
    $sub_array[] = '<button type="button" name="update" id="' . $row['user_id'] . '" class="btn btn-warning btn-xs update">Update</button>';
    $sub_array[] = '<button type="button" name="delete" id="' . $row['user_id'] . '" class="btn btn-danger btn-xs delete" data-status="' . $row['user_status'] . '">Delete</button>';
    $data[] = $sub_array;
}

// Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);






