<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css"> -->
<!-- <link rel="stylesheet" href="/resources/demos/style.css"> 
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script> -->
<!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> -->


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">


<br />
<div class=" container">
    <h2 align="center">VAC078 DRUGS INVENTORY</h2>
</div>

<?php

include('database_connection.php');
// include('header.php');

if (isset($_SESSION['type'])) {
    header('location:index.php');
}
$message = '';

if (isset($_POST['login'])) {
    $query = "SELECT * FROM user WHERE user_email = :user_email";
    $statement = $connect->prepare($query);
    $statement->execute(
        array(
            'user_email' => $_POST['user_email'],
        )
    );
    $count = $statement->rowCount();
    if ($count > 0) {
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            if (md5($_POST['user_password']) == $row['user_password']) {
                if ($row['user_status'] == 'active') {
                    $_SESSION['type'] = $row['user_type'];
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['user_name'] = $row['user_name'];
                    header("location:index.php");
                } else {
                    $message = "<label>User Disabled, Contact System Admin</label>";
                }
            } else {
                $message = "<label>Wrong Password</label>";
            }
        }
    } else {
        $message = "<label>Wrong Email Address</label>";
    }
}
?>


<!-- <html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VAC78 DRUGS INVENTORY</title>
    <script src="js/jquery-1.10.2.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <script src="js/bootstrap.min.js"></script>
</head> -->

<!-- <body> -->
<br />
<div class="container">
    <!-- <h2 align="center">VAC078 DRUGS INVENTORY</h2> -->
    <br />
    <div class="panel panel-default">
        <div class="panel-heading">
            <!-- Login -->
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
<!-- </body> -->

<!-- </html> -->


<?php
include 'footer.php';
?>