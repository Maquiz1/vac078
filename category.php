<?php
include 'database_connection.php';

if (!isset($_SESSION['type'])) {
    header('location:index.php');
}

include 'header.php';

?>


<span id="alert_action"></span>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                    <div class="row">
                        <h3 class="panel-title">Category List</h3>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 co l-xs-6">
                    <div class="row" align="" right>
                        <button type="button" name="add" id="add_button" data-toggle="modal" data-target="#categoryModal" class="btn btn-success btn-xs mr-auto">Add</button>
                    </div>
                </div>
                <div style="clear:both"></div>
            </div>
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
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i>Add Category</h4>
                </div>
            </div>
            <div class="modal-body">
                <label for="category_name">Enter Category Name</label>
                <input type="text" name="category_name" id="category_name" class="form-control" required />
            </div>
            <div class="modal-footer">
                <label for="category_id">Enter Category Name</label>
                <input type="hidden" name="category_id" id="category_id" />
                <input type="hidden" name="btn_action" id="btn_action" />
                <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
            </div>
        </form>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {

        $('#add_button').click(function(){
            $('#category_form')[0].reset();
            $('.modal-title').html("<i class='fa fa-plus'></i> Add Category");
            $('#action').val('Add');
            $('#btn_action').val('Add');
        });

        $(document).on('submit', '#category_form', function(event){
            event.preventDefault();
            $('#action').attr('disabled','disabled');
            var form_data = $(this).serialize();
            $.ajax({
                ur:"category_action.php",
                method:"POST",
                data:form_data,
                success:function(data){
                    $('#category_form')[0].reset();
                    $('#categoryModal').modal('hide');
                    $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                    $('#action').attr('disabled', false);
                    categoryDataTable.ajax.reload();
                }
            })
        })
        
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
    });
</script>


<?php
include 'footer.php';
?>