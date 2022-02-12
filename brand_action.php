<?php
include('database_connection.php');

if (isset($_POST['btn_action'])) {
    if ($_POST['btn_action'] == 'Add') {
        $query =
            "INSERT INTO 
            brand
            (category_id,brand_name)
            VALUES 
            (:category_id,:brand_name)
            ";


        $statement = $connect->prepare($query);
        $statement->execute([
            "category_id" => $_POST['category_id'],
            "band_name" => $_POST['brand_name']
        ]);
        $result = $statement->fetchAll();
        if (isset($result)) {
            echo 'New Brand Added';
        }
    }

    // if ($_POST['btn_action'] == 'fetch_single') {
    //     $query =
    //         "SELECT * FROM category WHERE category_id = :category_id";


    //     $statement = $connect->prepare($query);
    //     $statement->execute([
    //         "category_id" => $_POST['category_id']

    //     ]);
    //     $result = $statement->fetchAll();
    //     foreach ($result as $row) {
    //         $output = $row['category_name'];
    //     }
    //     echo json_encode($output);

    // }

    // if ($_POST['btn_action'] == 'Edit') {

    //     $query =
    //     "UPDATE 
    //     category 
    //     SET 
    //     category_name = :category_name
    //     WHERE 
    //     category_id = :category_id
    //     ";

    //     $statement = $connect->prepare($query);
    //     $statement->execute([
    //         'category_id'   => $_POST['category_id'],
    //         'category_name' => $_POST['category_name'],
    //     ]);

    //     $result = $statement->fetchAll();
    //     if (isset($result)) {
    //         echo 'Category Name  Updated';
    //     }
    // }


    // if ($_POST['btn_action'] == 'delete') {

    //     $status = 'Active';
    //     if($_POST['status'] == 'Active'){
    //         $status == 'Inactive';
    //     }
    //     $query = "UPDATE user SET category_status = :category_status WHERE category_id = :category_id";
    //     }

    //     $statement = $connect->prepare($query);
    //     $statement->execute([
    //         'category_status' => $status,
    //         'category_id' => $_POST['category_id']
    //     ]);
    //     $result = $statement->fetchAll();
    //     if (isset($result)) {
    //         echo 'Category status change to '. $status;
    //     }
    // }
}
