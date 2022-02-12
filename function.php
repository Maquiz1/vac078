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
?>