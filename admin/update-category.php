<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>

        <?php
        //check whether the id is set or not
        if (isset($_GET['id'])) {
            //get the id and all other details
            //echo "getting the data";
            $id = $_GET['id'];
            //create sql query to get all other details
            $sql = "SELECT*FROM tbl_category WHERE id=$id";

            //execute the query
            $res = mysqli_query($conn, $sql);

            //count the rows to check whether the id is valid or not
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                //get all the data
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            } else {
                //redirect to manage category with session message
                $_SESSION['no-category-found'] = "<div class='error'>Category Not Found.</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            }
        } else {
            //redirect to manage category page
            header('location:' . SITEURL . 'admin/manage-category.php');
        }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>" placeholder="Title ">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                        if ($current_image != "") {
                            //display the image
                        ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image ?>" width="150px">
                        <?php
                        } else {
                            //display the message
                            echo "<div class='error'>Image not added.</div>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if ($featured == "yes") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="yes">Yes
                        <input <?php if ($featured == "No") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="no">No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if ($featured == "yes") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="yes">yes
                        <input <?php if ($featured == "No") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="no">No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondry">
                    </td>
                </tr>
            </table>
        </form>

        <?php

        if (isset($_POST['submit'])) {
            //echo "clicked";
            //1. get all the valued from our form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //2.updating new image if selected
            //check whether the image is selected or not
            if (isset($_FILES['image'])) {
                //get the image details
                $image_name = $_FILES['image']['name'];

                //check whether the image is available or not
                if ($image_name != "") {
                    //image name is available

                    //upload the new image 

                    //Auto Rename our Image
                    //Get the extension of our image(jpg,png,gif etc) e.g. "food1.jpg"
                    $ext = end(explode('.', $image_name));

                    //rename the image
                    $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext; //e.g.Food_Category_834.


                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../images/category/" . $image_name;

                    //finally upload the image 
                    $upload = move_uploaded_file($source_path, $destination_path);

                    //check whether the image is uploaded or not
                    //And if image is not uploaded the we will stop the process and redirect with error message
                    if ($upload == false) {
                        //set message
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                        //redirect to add category page
                        header('location:' . SITEURL . 'admin/add-category.php');
                        //stop the process
                        die();
                    }


                    //8.remove the current image if available
                    if ($current_image != "") {
                        $remove_path = "../images/category/" . $current_image;
                        $remove = unlink($remove_path);

                        //check whether the image is removed or not 
                        //if failed to remove then display message and stop the process
                        if ($remove == false) {
                            //failed to remove image
                            $_SESSION['failed-remove'] = "<div class='error'>Failed To Remove Current Image.</div>";
                            header('location:' . SITEURL . 'admin/manage-category.php');
                            die(); //stop the process
                        }
                    }
                } else {
                    $image_name = $current_image;
                }
            } else {
                $image_name = $current_image;
            }

            //3.update the database
            $sql2 = "UPDATE tbl_category SET
            title='$title',
            image_name='$image_name',
            featured='$featured',
            active='$active'
            WHERE id=$id
            ";
            //execute the query
            $res2 = mysqli_query($conn, $sql2);

            //4.Redirect to Manage category with message
            //check whether query executed or not
            if ($res2 == true) {
                //category updated
                $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            } else {
                //fails to update category
                $_SESSION['update'] = "<div class='error'> Failed To Update Category.</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            }
        }


        ?>
    </div>
</div>

<?php include('partials/footer.php') ?>