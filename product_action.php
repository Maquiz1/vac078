<?php
include('database_connection.php');
include 'function.php';

if (isset($_POST['btn_action'])) {
    if ($_POST['btn_action'] == 'load_brand') {
        echo fill_brand_list($connect, $_POST['category_id']);
    }

    if ($_POST['btn_action'] == 'Add') {
        $query =
            "INSERT INTO 
            product
            (category_id,brand_id,product_name,product_description,product_quantity,product_unit,product_base_price,product_tax,product_entered_by,product_status,product_date)
            VALUES 
            (:category_id,:brand_id,:product_name,:product_description,:product_quantity,:product_unit,:product_base_price,:product_tax,:product_entered_by,:product_status,:product_date)
            ";


        $statement = $connect->prepare($query);
        $result = $statement->execute([
            "category_id"           => $_POST['category_id'],
            "brand_id"              => $_POST['brand_id'],
            "product_name"         => $_POST['product_name'],
            "product_description"  => $_POST['product_description'],
            "product_quantity"     => $_POST['product_quantity'],
            "product_unit"         => $_POST['product_unit'],
            "product_base_price"   => $_POST['product_base_price'],
            "product_tax"          => $_POST['product_tax'],
            "product_entered_by"   => $_SESSION['user_id'],
            "product_status"       => 'active',
            "product_date"         => date("Y-m-d")
        ]);
        if (isset($result)) {
            echo 'Product Added';
        }
    }


    if ($_POST['btn_action'] == 'product_details') {
        $query =
            "SELECT * FROM product
            INNER JOIN category 
            ON category.category_id = product.category_id
            INNER JOIN brand
            ON brand.brand_id = product.brand_id
            INNER JOIN user 
            ON user.user_id = product.product_entered_by
            WHERE product.product_id = '" . $_POST["product_id"] . "'
            ";


        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            if ($row['product_status'] == 'active') {
                $status = '<span class="label label-success">Active</span>';
            } else {
                $status = '<span class="label label-danger">Inactive</span>';
            }
        }

        $output = ' ';

        $output .=
            '<div> 
            <table>
            ';

        $output .=
            '
                <tr>
                    <td>Product Name</td>
                    <td>' . $row["product_name"] . '</td>
                </tr>
                <tr>
                    <td>Product Description</td>
                    <td>' . $row["product_description"] . '</td>
                </tr>
                <tr>
                    <td>Category Name</td>
                    <td>' . $row["category_name"] . '</td>
                </tr>
                <tr>
                    <td>Brand Name</td>
                    <td>' . $row["brand_name"] . '</td>
                </tr>
                <tr>
                    <td>Available Quantity</td>
                    <td>' . $row["product_quantity"] . ' ' . $row["product_unit"] . '</td>
                </tr>
                <tr>
                    <td>Product Base Price</td>
                    <td>' . $row["product_base_price"] . '</td>
                </tr>
                <tr>
                    <td>Product Tax (%)</td>
                    <td>' . $row["product_tax"] . '</td>
                </tr>
                <tr>
                    <td>Entered BY</td>
                    <td>' . $row["user_name"] . '</td>
                </tr>
                <tr>
                    <td>Product Status</td>
                    <td>' . $status . '</td>
                </tr>
                ';


        $output .=
            '
                </table>
                </div>
            ';

        echo $output;
    }


    if ($_POST['btn_action'] == 'fetch_single') {
        $query =
            "SELECT * FROM product WHERE product_id = :product_id";

        $statement = $connect->prepare($query);
        $statement->execute([
            "product_id" => $_POST['product_id']
        ]);
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $output['category_id']            = $row['category_id'];
            $output['brand_id']               = $row['brand_id'];
            $output['brand_select_box']       = fill_brand_list($connect, $row['category_id']);
            $output['product_name']           = $row['product_name'];
            $output['product_description']    = $row['product_description'];
            $output['product_quantity']       = $row['product_quantity'];
            $output['product_unit']           = $row['product_unit'];
            $output['product_base_price']     = $row['product_base_price'];
            $output['product_tax']            = $row['product_tax'];
        }
        echo json_encode($output);
    }

    if ($_POST['btn_action'] == 'Edit') {

        $query =
            "UPDATE 
            product
            SET
            category_id = :category_id,brand_id = :brand_id,product_name = :product_name,product_description = :product_description,product_quantity = :product_quantity,product_unit = :product_unit,product_base_price = :product_base_price,product_tax = :product_tax
            WHERE
            product_id = :product_id
            ";

        $statement = $connect->prepare($query);
        $result = $statement->execute([
            "category_id"          => $_POST['category_id'],
            "brand_id"             => $_POST['brand_id'],
            "product_name"         => $_POST['product_name'],
            "product_description"  => $_POST['product_description'],
            "product_quantity"     => $_POST['product_quantity'],
            "product_unit"         => $_POST['product_unit'],
            "product_base_price"   => $_POST['product_base_price'],
            "product_tax"          => $_POST['product_tax'],
            "product_id"           => $_POST['product_id']
        ]);
        if (isset($result)) {
            echo json_encode('Product Details  Updated');
        }
    }


    if ($_POST['btn_action'] == 'delete') {

        $status = 'active';
        if ($_POST['status'] == 'active') {
            $status == 'Inactive';
        }
        $query = "UPDATE product SET product_status = :product_status WHERE product_id = :product_id";

        $statement = $connect->prepare($query);
        $statement->execute([
            'product_status' => $status,
            'product_id' => $_POST['brand_id']
        ]);
        $result = $statement->fetchAll();
        if (isset($result)) {
            echo 'Product status change to ' . $status;
        }
    }
}
