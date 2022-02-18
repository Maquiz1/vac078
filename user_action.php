<?php
include('database_connection.php');

if (isset($_POST['btn_action'])) {
    if ($_POST['btn_action'] == 'Add') {
        $query =
            "INSERT INTO user
            (user_name, user_email, user_password, user_type, user_status)
            VALUES 
            (:user_name, :user_email, :user_password, :user_type, :user_status)
            ";
        $statement = $connect->prepare($query);
        $result = $statement->execute([
            "user_email"     => $_POST['user_email'],
            "user_status"    => "active",
            "user_name"      => $_POST['user_name'],
            "user_type"      => "user",
            "user_password"  => md5($_POST['user_password'])
        ]);
        if (isset($result)) {
            echo 'New User Added';
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
        $result = $statement->execute();
        if (isset($result)) {
            echo 'User Details Updated';
        }
    }


    if ($_POST['btn_action'] == 'delete') {
        $status = 'active';
        if($_POST['user_status'] == 'active'){
            $status = 'inactive';
        }
        $query = "UPDATE user SET user_status = :user_status WHERE user_id = :user_id";
        $statement = $connect->prepare($query);
        $result = $statement->execute([
            'user_status' => $status,
            'user_id'     => $_POST['user_id']
        ]);
        if (isset($result)) {
            echo json_encode('User status change to '. $status);
        }
    }
}
