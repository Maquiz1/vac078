<?php
function fill_category_list($connect){
    $query = "SELECT * FROM category
    WHERE category_status = 'active'
    ORDER BY category_name ASC
    ";

    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $output = ' ';
    foreach($result as $row){

        $output .= '<option value="'.$row["category_id"].'">'.$row["category_name"].'</option>';

       

    }
    return $output;


}


function fill_brand_list($connect,$category_id){
    $query = "SELECT * FROM brand
    WHERE brand_status = 'active'
    AND category_id = '".$category_id."'
    ORDER BY brand_name ASC
    ";

    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $output = ' ';
    foreach($result as $row){

        $output .= '<option value="'.$row["brand_id"].'">'.$row["brand_name"].'</option>';

       

    }
    return $output;


}

function get_user_name($connect, $user_id){
    $query = "SELECT user_name FROM user
    WHERE user_id = '".$user_id."'
    ";

    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();


    foreach($result as $row){

        return $row['user_name'];
       

    }
}


function fill_product_list($connect){
    $query = "SELECT * FROM product
    WHERE product_status = 'active'
    ORDER BY product_name ASC
    ";

    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $output = ' ';

    foreach($result as $row){

        $output .= '<option value="'.$row["product_id"].'">'.$row["product_name"].'</option>';       

    }
    return $output;
}

function fill_product_list1($connect,$product_id){
    $query = "SELECT * FROM product
    WHERE product_status = 'active'
    AND product_id = '".$product_id."'
    ORDER BY product_name ASC
    ";

    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $output = ' ';

    foreach($result as $row){

        $output .= '<option value="'.$row["product_id"].'">'.$row["product_name"].'</option>';       

    }
    return $output;
}


function fetch_product_details($product_id,$connect){
    $query = "SELECT * FROM product
    WHERE product_id = '".$product_id."'
    ";

    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    // return $result;

    $output[] = ' ';

    foreach($result as $row){

        $output['product_name'] = $row["product_name"];
        $output['quantity']     = $row["product_quantity"];
        $output['price']        = $row["product_base_price"];
        $output['tax']          = $row["product_tax"];      

    }
    return $output;
}

function available_product_quantity($connect, $product_id){
    $product_data = fetch_product_details($product_id, $connect);
    $query = "
     SELECT 
     inventory_order_product.quantity
     FROM 
     inventory_order_product
     INNER JOIN 
     inventory_order ON 
     inventory_order.inventory_order_id = inventory_order_product.inventory_order_id 
     WHERE 
     inventory_order_product.product_id = '".$product_id."' AND inventory_order.inventory_order_status = 'active'
    ";

    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $total = 0;


    foreach($result as $row){

        $total = $total + $row['quantity'];     

    }

    $available_quantity = intval($product_data['quantity']) - intval($total);

    if($available_quantity == 0){
        $update_query = "
        UPDATE product 
        SET 
        product_status = 'inactive'
        WHERE 
        product_id = '".$product_id."'
        ";

        $statement = $connect->prepare($update_query);
        $statement->execute();
        // $result = $statement->fetchAll();
        // $total = 0;
    }


    return $available_quantity ;

}
?>