<?php
include 'database_connection.php';

if (!isset($_SESSION['type'])) {
    header('location:index.php');
}

include 'header.php';


?>

<hr />
<span id="alert_action"></span>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                        <h3 class="panel-title">Category List</h3>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 co l-xs-6">
                        <div class="row">
                            <button type="button" name="add" id="add_button" data-toggle="modal" class="btn btn-success btn-xs">Add Category</button>
                        </div>
                    </div>
                </div>
                <div style="clear:both"></div>
            </div>

            <hr />

            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <table id="category_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category Name</th>
                                    <th>Status</th>
                                    <th>Edit</th>
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

<div id="categoryModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="category_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-plus"></i>Add Category</h4>
                    <button type="button" class="btn btn-close btn-danger" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Enter Category Name</label>
                    <input type="text" name="category_name" id="category_name" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="category_id" id="category_id">
                    <input type="hidden" name="btn_action" id="btn_action">
                    <input type="submit" name="action" id="action" class="btn btn-info" value="Add">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    $(document).ready(function() {

        var categoryDataTable = $('#category_data').DataTable({
            'processing': true,
            'serverSide': true,
            "order": [],
            'ajax': {
                url: "category_fetch.php",
                type: "POST"
            },
            'columnDefs': [{
                "target": [3, 4],
                "orderable": false
            }],
            "pageLength": 25

        });


        $('#add_button').click(function() {
            $('#categoryModal').modal('show');
            $('#category_form')[0].reset();
            $('.modal-title').html("<i class='fa fa-plus'></i> Add Category");
            $('#action').val('Add');
            $('#btn_action').val('Add');
        });

        $(document).on('submit', '#category_form', function(event) {
            event.preventDefault();
            $('#action').attr('disabled', 'disabled');
            var form_data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "category_action.php",
                data: form_data,
                contentType: "application/x-www-form-urlencoded",
                dataType: "html",
                success: function(data) {
                    // if ($.trim(data) == 'New Category Added') {
                        $('#category_form')[0].reset();
                        $('#categoryModal').modal('hide');
                        $('#alert_action').fadeIn().html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Success!</strong> ' + data + '</div>');
                        $('#action').attr('disabled', false);
                        categoryDataTable.ajax.reload();
                    // }
                    // else {
                    //     // window.location.href = encodeURI('http://localhost/ims/public/index.php?msg=Your are REGISTERE YOU CAN LOGIN');
                    // }
                }
            })
        })

        $(document).on('click', '.update', function() {
            var category_id = $(this).attr('id');
            var btn_action = 'fetch_single';
            $.ajax({
                url: "category_action.php",
                method: "POST",
                data: {
                    category_id: category_id,
                    btn_action: btn_action
                },
                dataType: "json",
                success: function(data) {
                    $('#categoryModal').modal('show');
                    $('#category_name').val(data.category_name);
                    $('.modal-title').html('<i class="fa fa-pencil-square-o"></i>Edit Category');
                    $('#category_id').val(category_id);
                    $('#action').val('Edit');
                    $('#btn_action').val('Edit');
                }
            })
        })

        $(document).on('click', '.delete', function() {

            var category_id = $(this).attr('id');
            var category_status = $(this).attr('data-status');
            var btn_action = 'delete';
            if (confirm("Are you sure you want to change status?")) {
                $.ajax({
                    url: "category_action.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        category_id: category_id,
                        btn_action: btn_action,
                        category_status: category_status
                    },
                    success: function(data) {
                        $('#alert_action').fadeIn().html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Success!</strong> ' + data + '</div>');
                        categoryDataTable.ajax.reload();
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