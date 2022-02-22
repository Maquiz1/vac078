<?php
include 'database_connection.php';

include 'function.php';

if (!isset($_SESSION['type'])) {
    header('location:login.php');
}

include 'header.php';

?>

<script>
    // $(document).ready(function() {
    //     $('#inventory_order_date').datepicker({
    //         format: "yyyy-mm-dd",
    //         autoclose: true
    //     });
    // })
</script>


<hr />
<span id="alert_action"></span>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                        <h3 class="panel-title">Order List</h3>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <div class="row">
                            <button type="button" name="add" id="add_button" data-toggle="modal" class="btn btn-success btn-xs">Add</button>
                        </div>
                    </div>
                </div>
                <hr>
                <!-- <div style="clear:both"></div> -->
            </div>
            <div class="panel-body">
                <table id="order_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Total Amount</th>
                            <th>Payment Status</th>
                            <th>Order Status</th>
                            <th>Order Date</th>
                            <?php
                            if ($_SESSION['type'] == 'master') {

                                echo '<th>Created By</th>';
                            }
                            ?>
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


<div id="orderModal" class="form-feed modal" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" id="order_form">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><i class="fa fa-plus"></i>Create Order</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <hr>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Enter Receiver Name</label>
                                <input type="text" name="inventory_order_name" id="inventory_order_name" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Enter Receiver Date</label>
                                <input type="text" name="inventory_order_date" id="inventory_order_date" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Enter Receiver Address</label>
                        <textarea name="inventory_order_address" id="inventory_order_address" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Enter Product Details </label>
                        <hr />
                        <span id="span_product_details">
                        </span>
                        <hr />
                    </div>
                    <div class="form-group">
                        <label>Select Payment Status </label>
                        <select name="payment_status" id="payment_status" class="form-control">
                            <option value="cash">Cash</option>
                            <option value="credit">Credit</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="inventory_order_id" id="inventory_order_id" />
                    <input type="hidden" name="btn_action" id="btn_action" />
                    <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
                </div>
            </div>
        </form>
    </div>
</div>


<!-- <div id="productDetailsModal" class="modal fade">
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
</div> -->


<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<!-- <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>


<script>
    $(document).ready(function() {

        var orderDataTable = $('#order_data').DataTable({
            'processing': true,
            'serverSide': true,
            "order": [],

            dom: 'lBfrtip',
            buttons: [{

                    extend: 'excelHtml5',
                    title: 'TOTAL ORDER AVAILABLE',
                    className: 'btn-primary'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'TOTAL ORDER AVAILABLE',
                    className: 'btn-primary',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'

                },
                // {
                //   extend: 'csvHtml5',
                //   title: 'REGISTERED PARTICIPANTS FOR RABIES',
                //   className: 'btn-primary'
                // },
                // {
                //   extend: 'copyHtml5',
                //   title: 'REGISTERED PARTICIPANTS FOR RABIES',
                //   className: 'btn-primary'
                // },
                // {
                //   extend: 'print',
                //   // name: 'printButton',
                //   title: 'REGISTERED PARTICIPANTS FOR RABIES'
                // }
            ],

            'ajax': {
                url: "order_fetch.php",
                type: "POST"
            },
            'columnDefs': [{
                "targets": [7, 8, 9],
                "orderable": false
            }],
            "pageLength": 20
        });

        $('#add_button').click(function() {
            $('#orderModal').modal('show');
            $('#order_form')[0].reset();
            $('.modal-title').html("<i class='fa fa-plus'></i> Create Order");
            $('#action').val('Add');
            $('#btn_action').val('Add');
            $('#span_product_details').html('');
            add_product_row();
        });

        function add_product_row(count = '') {
            var html = ' ';

            html += '<span id="row' + count + '">';
            html += '<div class="row">';
            html += '<div class="col-md-7">Name';
            html += '<select name="product_id[]" id="product_id' + count + '" class="form-control selectpicker" data-live-search="true" required>';
            html += '<option value="">Select Product</option>';
            html += '<?php echo fill_product_list($connect); ?>';
            html += '<input type="hidden" name="hidden_product_id[]" id="hidden_product_id' + count + '" /></select>';
            html += '</div>';
            html += '<div class="col-md-3">quantity';
            html += '<input type="text" name="quantity[]" class="form-control" required />';
            html += '</div>';
            html += '<div class="col-md-2">add';
            if (count == '') {
                html += '<button type="button" name="add_more" id="add_more" class="btn btn-success btn-xs">+</button>';
            } else {
                html += '<button type="button" name="remove" id="' + count + '" class="btn btn-danger btn-xs remove">-</button>'
            }
            html += '</div>';
            html += '</div>';
            html += '</div><br/>';
            html += '</span>';

            $('#span_product_details').append(html);


            // $('.selectpicker').selectpicker();
        }

        var count = 0;

        //ADD ROW
        $(document).on('click', '#add_more', function() {
            count = count + 1;
            add_product_row(count);
        })

        //REMOVE ROW
        $(document).on('click', '.remove', function() {
            var row_no = $(this).attr("id");
            $('#row' + row_no).remove()
        })


        //SUBMIT ORDER
        $(document).on('submit', '#order_form', function(event) {
            event.preventDefault();
            $('#action').attr('disabled', 'disabled');
            var form_data = $(this).serialize();
            $.ajax({
                url: "order_action.php",
                method: "POST",
                data: form_data,
                success: function(data) {
                    $('#order_form')[0].reset();
                    $('#orderModal').modal('hide');
                    $('#alert_action').fadeIn().html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Success!</strong> ' + data + '</div>');
                    $('#action').attr('disabled', false);
                    orderDataTable.ajax.reload();
                }
            })
        })


        $(document).on('click', '.update', function() {
            var inventory_order_id = $(this).attr('id');
            var btn_action = 'fetch_single';
            $.ajax({
                url: "order_action.php",
                method: "POST",
                data: {
                    inventory_order_id: inventory_order_id,
                    btn_action: btn_action
                },
                dataType: "json",
                success: function(data) {
                    $('#orderModal').modal('show');
                    $('#inventory_order_name').val(data.inventory_order_name);
                    $('#inventory_order_date').val(data.inventory_order_date);
                    $('#inventory_order_address').val(data.inventory_order_address);
                    $('#span_product_details').html(data.product_details);
                    $('#payment_status').val(data.payment_status);
                    $('.modal-title').html('<i class="fa fa-pencil-square-o"></i>Edit Order');
                    $('#inventory_order_id').val(inventory_order_id);
                    $('#action').val('Edit');
                    $('#btn_action').val('Edit');
                }
            })
        })


        $(document).on('click', '.delete', function() {
            var inventory_order_id = $(this).attr('id');
            var inventory_order_status = $(this).attr('data-status');
            var btn_action = 'delete';
            if (confirm("Are you sure you want to status?")) {
                $.ajax({
                    url: "order_action.php",
                    method: "POST",
                    data: {
                        inventory_order_id: inventory_order_id,
                        btn_action: btn_action,
                        inventory_order_status: inventory_order_status
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#alert_action').fadeIn().html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Success!</strong> ' + data + '</div>');
                        orderDataTable.ajax.reload();
                    }
                })
            } else {
                return false;
            }

        })


        // //FILTER BRAND
        // $('#category_id').change(function() {
        //     var category_id = $('#category_id').val();
        //     var btn_action = 'load_brand';
        //     $.ajax({
        //         ur: "product_action.php",
        //         method: "POST",
        //         data: {
        //             category_id: category_id,
        //             btn_action: btn_action
        //         },
        //         success: function(data) {
        //             $('#brand_id').html(data);
        //         }
        //     })
        // })


        // $(document).on('click', '.view', function() {
        //     var product_id = $(this).attr('id');
        //     var btn_action = 'fetch_single';
        //     $.ajax({
        //         ur: "product_action.php",
        //         method: "POST",
        //         data: {
        //             product_id: product_id,
        //             btn_action: btn_action
        //         },
        //         dataType: "json",
        //         success: function(data) {
        //             $('#productDetailsModal').modal('show');
        //             $('#product_details').modal(data);
        //         }
        //     })
        // })


    });
</script>


<?php
include 'footer.php';
?>