<?php
include('database_connection.php');


// try {
//     // $connect = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//     // set the PDO error mode to exception
//     $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     $sql = "INSERT INTO category (category_name)
//     VALUES ('Vaccine')";
//     // use exec() because no results are returned
//     $connect->exec($sql);
//     echo "New record created successfully";
//   } catch(PDOException $e) {
//     echo $sql . "<br>" . $e->getMessage();
//   }

//   $conn = null;


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
