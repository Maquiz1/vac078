<?php
include('database_connection.php');

if (isset($_POST['btn_action'])) {

    if ($_POST['btn_action'] == 'Add') {
        $query =
            "INSERT INTO 
            category
            (category_name)
            VALUES 
            (:category_name)
            ";

        $statement = $connect->prepare($query);
        $result = $statement->execute([
            "category_name" => $_POST['category_name'],
        ]);
        if (isset($result)) {
            echo 'New Category Added';
            exit();
        }
    }

    if ($_POST['btn_action'] == 'fetch_single') {
        $query =
            "SELECT * FROM category WHERE category_id = :category_id";


        $statement = $connect->prepare($query);
        $statement->execute([
            "category_id" => $_POST['category_id']

        ]);
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $output['category_name'] = $row['category_name'];
        }
        echo json_encode($output);
    }


    if ($_POST['btn_action'] == 'Edit') {

        $query =
        "UPDATE 
        category 
        SET 
        category_name = :category_name
        WHERE 
        category_id = :category_id
        ";

        $statement = $connect->prepare($query);
        $result = $statement->execute([
            'category_id'   => $_POST['category_id'],
            'category_name' => $_POST['category_name']
        ]);
        if (isset($result)) {
            echo 'Category Name  Updated';
        }
    }


    if ($_POST['btn_action'] == 'delete') {

        $status = 'active';
        if ($_POST['category_status'] == 'active') {
            $status = 'inactive';
        }
        $query = "UPDATE category SET category_status = :category_status WHERE category_id = :category_id";

        $statement = $connect->prepare($query);
        $result = $statement->execute([
            'category_status' => $status,
            'category_id' => $_POST['category_id']
        ]);
        if (isset($result)) {
            echo json_encode('Category status change to ' . $status);
            exit();
        }
    }
}
