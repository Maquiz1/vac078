<?php
include 'database_connection.php';

// include 'function.php';

if (!isset($_SESSION['type'])) {
    header('location:index.php');
}

if ($_SESSION['type'] != 'master') {
    header('location:index.php');
}

include 'header.php';

?>

<hr />

<span id="alert_action"></span>

<hr />

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                        <h3 class="panel-title">Product List</h3>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                    <div class="row">
                        <button type="button" name="add" id="add_button" data-toggle="modal" class="btn btn-success btn-xs">Add</button>
                    </div>
                </div>
                <!-- <div style="clear:both"></div> -->
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <table id="product_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category Name</th>
                                    <th>Brand Name</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Entered BY</th>
                                    <th>Status</th>
                                    <th>View</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="productModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="product_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i>Add Product</h4>
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <select name="category_id" id="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        <?
                        echo fill_category_list($connect);
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <select name="brand_id" id="brand_id" class="form-control" required>
                        <option value="">Select Brand</option>
                        <?
                        echo fill_category_list($connect);
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Enter Product Name</label>
                    <input type="text" name="product_name" id="product_name" class="form-control" required />
                </div>
                <div class="form-group">
                    <label>Enter Product Description</label>
                    <textarea name="product_description" id="product_description" cols="30" rows="10" required></textarea>
                </div>
                <div class="form-group">
                    <label>Enter Product Quantinty</label>
                    <input type="text" name="product_quantity" id="product_quantity" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" />
                    <span class="input-group-addon">
                        <select name="product_unit" id="product_unit">
                            <option value="">Select Unit</option>
                            <option value="Bags">Bags</option>
                            <option value="Bottles">Bottles</option>
                            <option value="Box">Box</option>
                        </select>
                    </span>
                </div>
                <div class="form-group">
                    <label>Enter Product Price</label>
                    <input type="text" name="product_base_price" id="product_base_price" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" /></input>
                </div>
                <div class="form-group">
                    <label>Enter Product Tax</label>
                    <input type="text" name="product_tax" id="product_tax" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" /></input>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="product_id" id="product_id" />
                <input type="hidden" name="btn_action" id="btn_action" />
                <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
            </div>
        </form>
    </div>
</div>


<div id="productDetailsModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="product_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i>Product Details</h4>
                </div>
            </div>
            <div class="modal-body">
                <div id="product_details">

                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {



        var productDataTable = $('#product_data').DataTable({
            'processing': true,
            'serverSide': true,
            "order": [],
            'ajax': {
                url: "product_fetch.php",
                type: "POST"
            },
            'columnDefs': [{
                "targets": [7, 8, 9],
                "orderable": false
            }],
            "pageLength": 20
        });

        $('#add_button').click(function() {
            $('#productModal').modal('show');
            $('#product_form')[0].reset();
            $('.modal-title').html("<i class='fa fa-plus'></i> Add Product");
            $('#action').val('Add');
            $('#btn_action').val('Add');
        });


        //FILTER BRAND
        $('#category_id').change(function() {
            var category_id = $('#category_id').val();
            var btn_action = 'load_brand';
            $.ajax({
                ur: "product_action.php",
                method: "POST",
                data: {
                    category_id: category_id,
                    btn_action: btn_action
                },
                success: function(data) {
                    $('#brand_id').html(data);
                }
            })
        })




        $(document).on('submit', '#product_form', function(event) {
            event.preventDefault();
            $('#action').attr('disabled', 'disabled');
            var form_data = $(this).serialize();
            $.ajax({
                ur: "product_action.php",
                method: "POST",
                data: form_data,
                success: function(data) {
                    $('#product_form')[0].reset();
                    $('#productModal').modal('hide');
                    $('#alert_action').fadeIn().html('<div class="alert alert-success">' + data + '</div>');
                    $('#action').attr('disabled', false);
                    productDataTable.ajax.reload();
                }
            })
        })


        $(document).on('click', '.view', function() {
            var product_id = $(this).attr('id');
            var btn_action = 'fetch_single';
            $.ajax({
                ur: "product_action.php",
                method: "POST",
                data: {
                    product_id: product_id,
                    btn_action: btn_action
                },
                dataType: "json",
                success: function(data) {
                    $('#productDetailsModal').modal('show');
                    $('#product_details').modal(data);
                }
            })
        })

        $(document).on('click', '.update', function() {
            var product_id = $(this).attr('id');
            var btn_action = 'fetch_single';
            $.ajax({
                ur: "product_action.php",
                method: "POST",
                data: {
                    product_id: product_id,
                    btn_action: btn_action
                },
                dataType: "json",
                success: function(data) {
                    $('#productModal').modal('show');
                    $('#category_id').val(data.category_id);
                    $('#brand_id').val(data.brand_select_box);
                    $('#brand_id').val(data.brand_id);
                    $('#product_name').val(data.product_name);
                    $('#product_description').val(data.product_description);
                    $('#product_quantity').val(data.product_quantity);
                    $('#product_unit').val(data.product_unit);
                    $('#product_base_price').val(data.product_base_price);
                    $('#product_tax').val(data.product_tax);
                    $('.modal-title').html('<i class="fa fa-pencil-square-o"></i>Edit Product');
                    $('#product_id').val(product_id);
                    $('#action').val('Edit');
                    $('#btn_action').val('Edit');
                }
            })
        })





        $(document).on('click', '.delete', function() {
            var product_id = $(this).attr('id');
            var status = $(this).attr('status');
            var btn_action = 'delete';
            if (confirm("Are you sure you want to status?")) {
                $.ajax({
                    ur: "product_action.php",
                    method: "POST",
                    data: {
                        product_id: product_id,
                        btn_action: btn_action,
                        status: status
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
                        brandDataTable.ajax.reload();
                    }
                })
            } else {
                return false;
            }

        })


    });
</script>


<?php
include 'footer.php';
?>