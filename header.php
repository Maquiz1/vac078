<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VAC78 DRUGS INVENTORY</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css"> -->
    <!-- <link rel="stylesheet" href="/resources/demos/style.css"> 
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script> -->
    <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> -->


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- Datatable JS -->
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <!-- Datatable CSS -->
    <link href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>

</head>

<body>
    <br />
    <div class=" container">
        <h2 align="center">VAC078 DRUGS INVENTORY</h2>


        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <!-- Brand -->
            <a class="navbar-brand" href="index.php">Home</a>

            <!-- Links -->
            <ul class="navbar-nav">
                <?php
                if ($_SESSION['type'] == 'master') {
                ?>

                    <li class="nav-item"><a class="nav-link" href="user.php">User</a></li>
                    <li class="nav-item"><a class="nav-link" href="category.php">Category</a></li>
                    <li class="nav-item"><a class="nav-link" href="brand.php">Brand</a></li>
                    <li class="nav-item"><a class="nav-link" href="product.php">Drugs List</a></li>
                <?php  }
                ?>

                <li class="nav-item"><a class="nav-link" href="order.php">Drugs Dispensed List</a></li>
            </ul>
            <!-- Dropdown -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                        <?php 
                        echo $_SESSION['user_name'] 
                        ?>
                    </a>
                    <div class="dropdown-menu ml-auto">
                        <a class="dropdown-item" href="profile.php">Profile</a>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>