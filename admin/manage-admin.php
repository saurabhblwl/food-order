<?php include 'partials/menu.php'; ?>

<!-- Main content section starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>
        <br>
        <?php
         if (isset($_SESSION['add'])) {
            echo $_SESSION['add']; //Displaying session messege
            unset($_SESSION['add']); //Removing session messege
        } 

        if(isset($_SESSION['delete']))
        {
            echo $_SESSION['delete'];
            unset ($_SESSION['delete']);
        }
        if (isset($_SESSION['update']))
        {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        if(isset($_SESSION['user-not-found']))
        {
            echo $_SESSION['user-not-found'];
            unset($_SESSION['user-not-found']);
        }
        if(isset($_SESSION['pwd-not-match']))
        {
            echo $_SESSION['pwd-not-match'];
            unset($_SESSION['pwd-not-match']);
        }
        if(isset($_SESSION['change-pwd']))
        {
            echo $_SESSION['change-pwd'];
            unset($_SESSION['change-pwd']);
        }
         ?>
        <br>
        <!-- button to add admin -->
        <br><br><br>
        <a href="add-admin.php" class="btn-primary">Add Admin</a>
        <br><br><br>
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>
            <?php
            //query to get all admin
            $sql = "SELECT * FROM tbl_admin";
            //execute the query
            $res = mysqli_query($conn, $sql);

            //check whether the query is executed of not
            if ($res == true) {
                //count rows to check whether we have data in database or not
                $rows = mysqli_num_rows($res); //function to get all the rows in database

                $sn=1;//create a variable and assign the value 


                //check the number of rows
                if ($rows > 0) {
                    //we have data in database
                    while ($rows = mysqli_fetch_assoc($res)) {

                        //using while loop to get all the data from database.
                        //while loop will run as long as we hava data in database

                        //get indivisual Data
                        $id = $rows['id'];
                        $full_name = $rows['full_name'];
                        $username = $rows['user_name'];

                        //display the value in our table
            ?>
                        <tr>
                            <td><?php echo $sn++;?></td>
                            <td><?php echo $full_name; ?></td>
                            <td><?php echo $username; ?></td>
                            <td>
                                <a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id?>" class="btn-primary">change password</a>
                                <a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id?>" class="btn-secondry">Update Admin</a>
                                <a href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id?>" class="btn-danger">Delete Admin</a>


                            </td>

                        </tr>

            <?php
                    }
                } else {
                    //we dont have data in database
                }
            }
            ?>

        </table>

    </div>
</div>
<!-- Main content section starts -->

<?php include 'partials/footer.php'; ?>