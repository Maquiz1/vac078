<?php
include('database_connection.php');
include 'function.php';

if (!isset($_SESSION['type'])) {
    header('location:login.php');
}
else{
    include('header.php');
}




?>

<br />

<?php
if ($_SESSION['type'] == 'master') {
?>
    <div class="row">

        <div class="col-sm-3 mb-3 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><strong>Total Users</strong></h5>
                    <p class="card-text">
                    <h1>
                        <?php
                        echo count_total_user($connect);
                        ?>
                    </h1>
                    </p>
                    <a href="user.php" class="btn btn-primary">See More</a>
                </div>
            </div>
        </div>


        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><strong>Total Category</strong></h5>
                    <p class="card-text">
                    <h1>
                        <?php
                        echo count_total_category($connect);
                        ?>
                    </h1>
                    </p>
                    <a href="category.php" class="btn btn-primary">See More</a>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><strong>Total Brand</strong></h5>
                    <p class="card-text">
                    <h1>
                        <?php
                        echo count_total_brand($connect);
                        ?>
                    </h1>
                    </p>
                    <a href="brand.php" class="btn btn-primary">See More</a>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><strong>Total Products</strong></h5>
                    <p class="card-text">
                    <h1>
                        <?php
                        echo count_total_product($connect);
                        ?>
                    </h1>
                    </p>
                    <a href="product.php" class="btn btn-primary">See More</a>
                </div>
            </div>
        </div>
    </div>

<?php
}
?>

<br />
<div class="row">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><strong>Total Order Value</strong></h5>
                <p class="card-text">
                <h1>
                    <?php
                    echo count_total_order($connect);
                    ?>
                </h1>
                </p>
                <a href="order.php" class="btn btn-primary">See More</a>
            </div>
        </div>
    </div>


    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><strong>Total Cash Order Value</strong></h5>
                <p class="card-text">
                <h1>
                    <?php
                    echo count_total_cash_order_value($connect);
                    ?>
                </h1>
                </p>
                <a href="#!" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><strong>Total Credit Order Value</strong></h5>
                <p class="card-text">
                <h1>
                    <?php
                    echo count_total_credit_order_value($connect);
                    ?>
                </h1>
                </p>
                <a href="#!" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </div>

</div>

<br />
<?php
if ($_SESSION['type'] == 'master') {
?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><strong>Total Order Value User Wise</strong></h5>
                    <p class="card-text">
                    <h1>
                        <?php
                        echo get_user_wise_total_order($connect);
                        ?>
                    </h1>
                    </p>
                    <a href="#!" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>

<?php
include 'footer.php';
?>