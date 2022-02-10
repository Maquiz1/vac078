<?php 
    include('database_connection.php');
    if(isset($_SESSION['type'])){
        header('location:index.php');
    }
    $message = '';

    if(isset($_POST['login'])){
        $query = "SELECT * FROM user WHERE user_email = :user_email";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                'user_email' => $_POST['user_email'],
            )
        );
        $count = $statement->rowCount();
        if($count > 0){
            $result = $statement->fetchAll();
            foreach($result as $row){
                if(md5($_POST['user_password']) == $row['user_password']){
                    if($row['user_status'] == 'Active'){
                        $_SESSION['type'] = $row['user_type'];
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['user_name'] = $row['user_name'];
                        header("location:index.php");
                    }else{
                        $message = "<label>User Disabled, Contact System Admin</label>";
                    }
                }else{
                    $message = "<label>Wrong Password</label>";
                }
            }
        }else{
            $message = "<label>Wrong Email Address</label>";
        }
    }
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VAC78 DRUGS INVENTORY</title>
    <script src="js/jquery-1.10.2.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
    <br />
    <div class="container">
        <h2 align="center">VAC078 DRUGS INVENTORY</h2>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">
                Login
            </div>
            <div class="panel-body">
                <form action="#" method="post">
                    <?php echo $message; ?>
                    <div class="form-group">
                        <label for="user_email">User Email</label>
                        <input type="text" name="user_email" class="form-control" id="user_email" required />
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="user_password" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Login" name="login" class="btn btn-info" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>