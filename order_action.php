<?php
include('database_connection.php');

include 'function.php';

if (isset($_POST['btn_action'])) {

    if ($_POST['btn_action'] == 'Add') {
        $query =
            "INSERT INTO 
            inventory_order
            (user_id,inventory_order_total,inventory_order_date,inventory_order_name,inventory_order_address,payment_status,inventory_order_status,inventory_order_created_date)
            VALUES 
            (:user_id,:inventory_order_total,:inventory_order_date,:inventory_order_name,:inventory_order_address,:payment_status,:inventory_order_status,:inventory_order_created_date)
            ";


        $statement = $connect->prepare($query);
        $statement->execute([
            "user_id"                      => $_SESSION['user_id'],
            "inventory_order_total"        => 0,
            "inventory_order_date"         => $_POST['inventory_order_date'],
            "inventory_order_name"         => $_POST['inventory_order_name'],
            "inventory_order_address"      => $_POST['inventory_order_address'],
            "payment_status"               => $_POST['payment_status'],
            "inventory_order_status"       => 'active',
            "inventory_order_created_date" => date("Y-m-d")
        ]);
        $result = $statement->fetchAll();
        $last_id = $connect->lastInsertId();
        if (isset($last_id)) {
            $total = 0;
        }
        for ($count = 0; $count < count($_POST["product_id"]); $count++) {
            $product_details = fetch_product_details($_POST["product_id"][$count], $connect);

            $sub_query =
                "INSERT INTO 
                 inventory_order_product
                 (inventory_order_id,product_id,quantity,price,tax)
                 VALUES 
                 (:inventory_order_id,:product_id,:quantity,:price,:tax)
                 ";


            $statement = $connect->prepare($sub_query);
            $statement->execute([
                "inventory_order_id"  => $inventory_order_id,
                "roduct_id"           => $_POST["product_id"][$count],
                "quantity"            => $_POST["quantity"][$count],
                "price"               => $product_details["price"],
                "tax"                 => $product_details["tax"],
            ]);

            $base_price = $product_details['price'] * $_POST["quantity"][$count];
            $tax = ($base_price / 100) * $product_details['tax'];
            $total_amount = $total_amount + ($base_price + $tax);
        }

        $update_query =
            "UPDATE 
            inventory_order
            SET
            inventory_order_total = '" . $total_amount . "'
            WHERE
            inventory_order_id = '" . $inventory_order_id . "'
            ";

        $statement = $connect->prepare($update_query);
        $statement->execute();
        $result = $statement->fetchAll();
        if (isset($result)) {
            echo 'Order Created....';
        }
    }

    

    if ($_POST['btn_action'] == 'fetch_single') {
        $query =
            "SELECT * FROM inventory_order WHERE inventory_order_id = :inventory_order_id";


        $statement = $connect->prepare($query);
        $statement->execute([
            "inventory_order_id" => $_POST['inventory_order_id']
        ]);
        $result = $statement->fetchAll();
        $output = array();
        foreach ($result as $row) {
            $output['inventory_order_name']    = $row['inventory_order_name'];
            $output['inventory_order_date']    = $row['inventory_order_date'];
            $output['inventory_order_address'] = $row['inventory_order_address'];
            $output['payment_status']          = $row['payment_status'];
        }

        $sub_query =
                "SELECT * FROM inventory_order_product
                 WHERE
                 inventory_order_id = '".$_POST["inventory_order_id"]."'
                 ";

            $statement = $connect->prepare($sub_query);
            $statement->execute();
            $sub_result = $statement->fetchAll();
            $product_details = '';
            $count = '';

            foreach($sub_result as $sub_row){
                $product_details .= '
                    <span id="row".$count.'"
                ';
            }



        echo json_encode($output);
    }


    //     if ($_POST['btn_action'] == 'product_details') {
    //         $query =
    //             "SELECT * FROM product
    //         INNER JOIN category 
    //         ON category.category_id = product.category_id
    //         INNER JOIN brand
    //         ON brand.brand_id = product.brand_id
    //         INNER JOIN user 
    //         ON user.user_id = product.product_entered_by
    //         WHERE product.product_id = '" . $_POST["product_id"] . "'
    //         ";


    //         $statement = $connect->prepare($query);
    //         $statement->execute();
    //         $result = $statement->fetchAll();
    //         foreach ($result as $row) {
    //             $status = ' ';
    //             if ($row['product_status'] == 'active') {
    //                 $status = '<span class="label label-success">Active</span>';
    //             } else {
    //                 $status = '<span class="label label-danger">Inactive</span>';
    //             }
    //         }

    //         $output .=
    //             '
    //             <tr>
    //                 <td>Product Name</td>
    //                 <td>' . $row["product_name"] . '</td>
    //             </tr>
    //             <tr>
    //                 <td>Product Description</td>
    //                 <td>' . $row["product_dscription"] . '</td>
    //             </tr>
    //             <tr>
    //                 <td>Ctegory Name</td>
    //                 <td>' . $row["category_name"] . '</td>
    //             </tr>
    //             <tr>
    //                 <td>Brand Name</td>
    //                 <td>' . $row["brand_name"] . '</td>
    //             </tr>
    //             <tr>
    //                 <td>Available Quantity</td>
    //                 <td>' . $row["product_quantity"] . ' ' . $row["product_unit"] . '</td>
    //             </tr>
    //             <tr>
    //                 <td>Product Base Price</td>
    //                 <td>' . $row["product_base_price"] . '</td>
    //             </tr>
    //             <tr>
    //                 <td>Product Tax (%)</td>
    //                 <td>' . $row["product_tax"] . '</td>
    //             </tr>
    //             <tr>
    //                 <td>Entered BY</td>
    //                 <td>' . $row["user_namee"] . '</td>
    //             </tr>
    //             <tr>
    //                 <td>Product Status</td>
    //                 <td>' . $status . '</td>
    //             </tr>
    //             ';
    //     }

    //     $output .=
    //         '
    //         </table>
    //         </div>
    //     ';

    //     echo $output;
    // }



    // if ($_POST['btn_action'] == 'Edit') {

    //     $query =
    //         "UPDATE 
    //         product
    //         SET
    //         category_id = :category_id,brand_id = :brand_id,product_name = :product_name,product_description = :product_description,product_quantity = :product_quantity,product_unit = :product_unit,product_base_price = :product_base_price,product_tax = :product_tax
    //         WHERE
    //         product_id = :product_id
    //         ";

    //     $statement = $connect->prepare($query);
    //     $statement->execute([
    //         "category_id"          => $_POST['category_id'],
    //         "brand_id"             => $_POST['brand_id'],
    //         "product_name"         => $_POST['product_name'],
    //         "product_description"  => $_POST['product_description'],
    //         "product_quantity"     => $_POST['product_quantity'],
    //         "product_unit"         => $_POST['product_unit'],
    //         "product_base_price"   => $_POST['product_base_price'],
    //         "product_tax"          => $_POST['product_tax'],
    //         "product_id"           => $_POST['product_id']
    //     ]);

    //     $result = $statement->fetchAll();
    //     if (isset($result)) {
    //         echo 'Product Details  Updated';
    //     }
    // }


    // if ($_POST['btn_action'] == 'delete') {

    //     $status = 'active';
    //     if ($_POST['status'] == 'active') {
    //         $status == 'Inactive';
    //     }
    //     $query = "UPDATE product SET product_status = :product_status WHERE product_id = :product_id";

    //     $statement = $connect->prepare($query);
    //     $statement->execute([
    //         'product_status' => $status,
    //         'product_id' => $_POST['brand_id']
    //     ]);
    //     $result = $statement->fetchAll();
    //     if (isset($result)) {
    //         echo 'Product status change to ' . $status;
    //     }
    // }


}
