<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VAC78 DRUGS INVENTORY</title>
    <!-- <script src="js/jquery-1.10.2.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
    <script src="js/bootstrap.min.js"></script> -->



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

        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="index.php" class="navbar-brand">Home</a>
                    <ul class="nav navbar-nav">
                        <?php
                        if ($_SESSION['type'] == 'master') {
                        ?>

                            <li><a href="user.php">User</a></li>
                            <li><a href="category.php">Cetegory</a></li>
                            <li><a href="brand.php">Brand</a></li>
                            <li><a href="product.php">Product</a></li>

                        <?php  }
                        ?>
                        <li><a href="order.php">Order</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropwdown-toggle" data-toggle="dropdown">
                                <span class="label label-pill label-danger count"></span>
                                <?php echo $_SESSION['user_name'] ?>
                            </a>
                            <ul class="dropdown">
                                <li><a href="profile.php">Profile</a></li>
                                <li><a href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>