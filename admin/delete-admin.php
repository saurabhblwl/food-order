
<?php
//include constants.php file here
include('../config/constants.php');
//1. get the ID of Admin to be deleted
$id = $_GET['id'];
//2.query to delete admin
$sql = "DELETE FROM tbl_admin WHERE id=$id";

//execute the query
$res = mysqli_query($conn, $sql);

//check whether the query executed successfullly or not
if($res==true)
{
    //query executed successfully
    //echo "admin deleted";
    //create session variable to display messege
    $_SESSION['delete']="<div class='success'>Admin Deleted succesfully</div>";
    //redirect to manage admin
    header('location:'.SITEURL.'admin/manage-admin.php');
}
else{
    //failed to delete admin 
    //echo "failed to delete admin";
    $_SESSION['delete'] = "<div class='error'Failed to delete admin.Try again later.</div>";
    header('location:' . SITEURL . 'admin/manage-admin.php');

}
//3. Redirect to manage admin page with messege(success/Error)



?>