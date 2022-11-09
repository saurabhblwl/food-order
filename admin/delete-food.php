<?php
//include constants page
include('../config/constants.php');
// echo "delete food page";
    
    if(isset($_GET['id']) && isset($_GET['image_name']))//either use'&&' or 'AND'
    {
        //process to delete
        // echo "process to delete";
        //1. Get id and image name
           $id=$_GET['id'];
           $image_name=$_GET['image_name'];
        //2. Remove the image if available
          //check whether the image is available or not and delete only if available
          if($image_name!="")
          {
            //It has image and need to remove from folder
            //Get the image path
            $path="../images/food/".$image_name;
             
            //remove image file from folder
            $remove=unlink($path);
          

            //check whether the image is removed or not
            if($remove==false)
            {
                //failed to remove image
                $_SESSION['upload']="<div class='error'>Failed To Remove Image.</div>";
                //redirect to Manage Food
                header('location:'.SITEURL.'admin/manage-food.php');
                //stop the process of deleting food
                die();
            }
          }
        
        //3. Delete food from database
        //creating a sql query
        $sql="DELETE FROM tbl_food WHERE id=$id";
        //execute the query
        $res=mysqli_query($conn,$sql);
        //check whether query is executed or not and set the session message respectively
        //Redirect to manage food with session message
        if($res==true)
        {
          //food deleted

          $_SESSION['delete']="<div class='success'>Food Deleted Successfully.</div>";
          header('location:'.SITEURL.'admin/manage-food.php');
        }
        else{
    //failed to delete food
    $_SESSION['delete'] = "<div class='error'>Failed To Delete Food.</div>";
    header('location:' . SITEURL . 'admin/manage-food.php');
        }


    }
    else{
        //redirect to manage food page
        //echo "redirect";
        $_SESSION['unauthorized']="<div class='error'>Unauthorized Access.<?div>";
        header('location:'.SITEURL.'admin/manage-food.php'); 
    }
?>