<?php
include('database_connection.php');

if (isset($_POST['btn_action'])) {
    if ($_POST['btn_action'] == 'Add') {
        $query =
            "INSERT INTO brand (category_id,brand_name) VALUES (:category_id,:brand_name)
            ";


        $statement = $connect->prepare($query);
        $result = $statement->execute([
            "category_id"  => $_POST['category_id'],
            "brand_name"    => $_POST['brand_name'],
        ]);
        if (isset($result)) {
            echo 'New Brand Added';
        }
    }

    if ($_POST['btn_action'] == 'fetch_single') {
        $query =
            "SELECT * FROM brand WHERE brand_id = :brand_id";


        $statement = $connect->prepare($query);
        $statement->execute([
            "brand_id" => $_POST['brand_id']
        ]);
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $output['category_id'] = $row['category_id'];
            $output['brand_name'] = $row['brand_name'];
        }
        echo json_encode($output);

    }

    if ($_POST['btn_action'] == 'Edit') {

        $query =
        "UPDATE 
        brand 
        SET 
        category_id = :category_id,
        brand_name = :brand_name
        WHERE 
        brand_id = :brand_id
        ";

        $statement = $connect->prepare($query);
        $result = $statement->execute([
            'category_id'   => $_POST['category_id'],
            'brand_name' => $_POST['brand_name'],
            'brand_id'   => $_POST['brand_id']
        ]);
        if (isset($result)) {
            echo 'Brand Name  Updated';
            // echo '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Success!</strong> Brand Name  Updated </div>';
        }
    }


    if ($_POST['btn_action'] == 'delete') {

        $status = 'active';
        if($_POST['brand_status'] == 'active'){
            $status = 'inactive';
        }
        $query = "UPDATE brand SET brand_status = :brand_status WHERE brand_id = :brand_id";
        $statement = $connect->prepare($query);
        $result = $statement->execute([
            'brand_status' => $status,
            'brand_id' => $_POST['brand_id']
        ]);
        if (isset($result)) {
            echo json_encode('Brand status change to '. $status);
        }
    }
}
