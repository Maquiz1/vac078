<?php
    include('database_connection.php');
    
    if(isset($_SESSION['user_name'])){ 
        if($_POST['user_new_password'] != ''){
            $query =
            "UPDATE user SET 
            user_name = '".$_POST["user_name"]."', 
            user_email = '".$_POST["user_email"]."',
            user_new_password = '".md5($_POST["user_new_password"])."',
            re_enter_user_password = '".md5($_POST["re_enter_user_password"])."'
               WHERE 
            user_id = '".$_SESSION["user_id"]."'
            ";
        }else{
            $query = "UPDATE user 
            SET  
            user_name = '".$_POST["user_name"]."',
            user_email = '".$_POST["user_email"]."',
            WHERE 
            user_id = '".$_SESSION["user_id"]."'
            ";
        }
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->execute();
        if(isset($result)){
            echo '<div class="alert aler-success">Profile Eidted</div>';
        }
    }

    // include('header.php');
?>