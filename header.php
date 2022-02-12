<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VAC78 DRUGS INVENTORY</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Datatable CSS -->
    <link href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>



    <!-- Datatable JS -->
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>





</head>

<body>
    <br />
    <div class="container">
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
                    <li class="nav-item"><a class="nav-link" href="product.php">Priduct</a></li>
                <?php  }
                ?>
                <li class="nav-item"><a class="nav-link" href="order.php">Order</a></li>
                <!-- Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                        <?php echo $_SESSION['user_name'] ?>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="profile.php">Profile</a>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>


        


    