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
        $statement->execute([
            "category_name" => $_POST['category_name'],
        ]);
        $result = $statement->fetchAll();
        if (isset($result)) {
            echo 'New Category Added';
        }
    }

    if ($_POST['btn_action'] == 'fetch_single') {
        $query =
            "SELECT * FROM user WHERE user_id = :user_id";


        $statement = $connect->prepare($query);
        $statement->execute([
            "user_id" => $_POST['user_id']

        ]);
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $output['user_email'] = $row['user_email'];
            $output['user_name'] = $row['user_name'];
        }
        echo json_encode($output);
    }

    if ($_POST['btn_action'] == 'Edit') {


        if ($_POST['user_password'] != ' ') {
            $query =
                "UPDATE user 
        SET 
        user_name = '" . $_POST["user_name"] . "',
        user_email = '" . $_POST["user_email"] . "',
        user_password = '" . md5($_POST["user_password"]) . "'
        WHERE 
        user_id = '" . $_POST["user_id"]  . "'
        ";
        } else {
            $query =
                "UPDATE user SET 
        user_name = '" . $_POST['user_name'] . "',
        user_email = '" . $_POST['user_email'] . "',
        WHERE 
        user_id = '" . $_POST['user_id'] . "'
        ";
        }

        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        if (isset($result)) {
            echo 'User Details Updated';
        }
    }


    if ($_POST['btn_action'] == 'delete') {


        $status = 'Active';
        if($_POST['status'] == 'Active'){
            $status == 'Inactive';
        }
        $query = "UPDATE user SET user_status = :user_status WHERE user_id = :user_id";
        }

        $statement = $connect->prepare($query);
        $statement->execute([
            'user_status' => $status,
            'user_id' => $_POST['user_id']
        ]);
        $result = $statement->fetchAll();
        if (isset($result)) {
            echo 'User status change to '. $status;
        }
    }
}
