<?php
include('database_connection.php');
// $message = ''; 
if (!isset($_SESSION['type'])) {
    header('location:login.php');
}


$query = "SELECT * FROM user WHERE user_id = '" . $_SESSION["user_id"] . "'";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$name = '';
$email = '';
$user_id = '';


foreach ($result as $row) {
    $name = $row['user_name'];
    $email = $row['user_email'];
}

include('header.php');

?>



<div class="panel panel-default">
    <div class="panel-heading">
        Edit Profile
    </div>
    <div class="panel-body">
        <form method="post" id="edit_profile_form">
            <span id="message"></span>
            <div class="form-group">
                <label for="user_name">User Name</label>
                <input type="text" name="user_name" class="form-control" id="user_name" value="<?php echo $name; ?>" required />
            </div>
            <div class="form-group">
                <label for="user_email">User Email</label>
                <input type="email" name="user_email" class="form-control" id="user_email" value="<?php echo $email; ?>" required />
            </div>
            <hr />
            <label>Leave Blanl if you don't want to change passowrd</label>
            <div class="form-group">
                <label for="user_new_password">New Password</label>
                <input type="password" name="user_new_password" class="form-control" id="user_new_password" />
            </div>
            <div class="form-group">
                <label for="re_enter_user_password">Re-enter Password</label>
                <input type="password" name="re_enter_user_password" class="form-control" id="re_enter_user_password" />
                <span id="err_password"></span>
            </div>
            <div class="form-group">
                <input type="submit" value="Edit Profile" name="edit_profile" id="edit_profile" class="btn btn-info" />
            </div>
        </form>
    </div>
</div>



<script>

    $(document).ready(function(){
        $('#edit_profile_form').on('submit', function(event){
            event.preventDefault();
            if($('#user_new_password').val() != ''){
                if($('#user_new_password').val() != $('#re_enter_user_password').val()){
                    $('#err_password').html('<label class="text-danger">Password Not Match</label>');
                }else{
                    $('#err_password').html('');
            }
            }
            $('#edit_profile').attr('disabled', 'disabled');  
            var form_data = $(this).serialize();
            $.ajax({
                url: 'edit_profile.php',
                method: "POST",
                data:form_data,
                success:function(data){
                    $('#edit_profile').attr('disabled', false);  
                    $('#user_new_password').val('');  
                    $('#re_enter_user_password').val('');  
                    $('#message').html(data);  
                }
            })
        });
    });

</script>




