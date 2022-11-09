<?php include('partials/menu.php'); ?>



<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>
<?php
if(isset( $_SESSION['add']))//checking whether the session is set or not
{
    echo $_SESSION['add'];//Display the session messege if set
    unset($_SESSION['add']);//Removing session messege
}
?>
<br>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td><input type="text" name="full_name" placeholder="Enter Your Name"></td>
                </tr>
                <tr>
                    <td>User Name</td>
                    <td>
                        <input type="text" name="user_name" placeholder="your user name">
                    </td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td>
                        <input type="password" name="password" placeholder="password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondry">
                    </td>
                </tr>

            </table>
        </form>
    </div>
</div>



<?php include('partials/footer.php'); ?>

<?php 
//process the value from form and save it in Database
//check whether the submit button is clicked or not

if(isset($_POST['submit']))
{
    //echo 'Button clicked';

    //1. get the data from form
      $full_name=$_POST['full_name'];
      $username=$_POST['user_name'];
      $password=md5($_POST['password']);//md5 used for password encryption

      //2. sql query to save the data into database
      $sql="INSERT INTO tbl_admin SET
      full_name='$full_name',
     user_name='$username',
     password='$password'
     ";
    
    //3. Executing query and saving data into database
     $res = mysqli_query($conn,$sql) or die(mysqli_error());

     //4. check whether the (query is executed) data is inserted or not and display appropriate message
      if($res==TRUE)
      {
        //Data inserted
        //echo "data inserted";
        //create a session variable to display messege
        $_SESSION['add'] = "Admin Added successfully";
        //redirect page To manage admin
        header("location:".SITEURL.'admin/manage-admin.php');
      }
      else{
        //Failed to insert Data
        //echo"failed to insert data";
        $_SESSION['add'] = "failed to add admin";
        //redirect page To add admin
        header("location:" . SITEURL . 'admin/add-admin.php');
      }
}

?>