<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change password</h1>
<br><br>
    <?php 
      if (isset($_GET['id']))
      {
        $id=$_GET['id'];
      }
    
    ?>
          <form action="" method="POST">

          <table class="tbl-30">
        <tr>
            <td>current password:</td>
            <td>
                <input type="password" name="current_password" placeholder="current password">
            </td>
        </tr>
        <tr>
            <td>New password:</td>
            <td>
                <input type="password" name="new_password" placeholder="New Password">
            </td>
        </tr>
        <tr>
            <td>confirm password</td>
            <td>
                <input type="password" name="confirm_password" placeholder="confirm password">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <input type="submit" name="submit" value="change password" class="btn-secondry">
            </td>
        </tr>
          </table>
          </form>

    </div>
</div>
<?php

//check weather the submit button is clicked or not
if(isset($_POST['submit']))
{
    // echo"clicked";

    //1. Get the data from form
    $_POST['id'];
    $current_password =md5( $_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    //2.Check whether the user with current id and current password exists or not
    $sql= "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
    //execute the quey
    $res = mysqli_query($conn,$sql);
    if($res==true)
    {
        //check whether data is available or not
        $count=mysqli_num_rows($res);
        if($count==1)
        {
            //user exists and password can be changed
            // echo"user found";
            //whether the new password and confirm match or not
            if($new_password==$confirm_password)
            {
                //update the password
                $sql2="UPDATE tbl_admin SET
                password='$new_password'
                WHERE id=$id
                ";
                //execute the query 
                $res2= mysqli_query($conn,$sql2);
                //check whether the query is executed or not
                if($res==true)
                {
                    //display success messege
                    $_SESSION['change-pwd'] = "<div class='success'>password changed successfully</div>";
                    //redirect the user
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                }           
                else{
                    //display error messege
                    $_SESSION['change-pwd'] = "<div class='error'>failed to change password</div>";
                    //redirect the user
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                }
            }
            else{
                //redirect to manage admin page with errror messege
                $_SESSION['pwd-not-match'] = "<div class='error'>password did not match.</div>";
                //redirect the user
                header('location:' . SITEURL . 'admin/manage-admin.php');
            }
            
        }
        else{
            //user does not exist set messege and redirect
            $_SESSION['user-not-found']="<div class='error'>user not found</div>";
            //redirect the user
            header('location:'.SITEURL.'admin/manage-admin.php');   
        }
    }    
    //3. check whether the password and confirm password match or not


    //4. change password if all above is true
}
?>

<?php include ('partials/footer.php')?>. 