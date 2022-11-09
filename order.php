<?php include('partial-front/menu.php'); ?>

<?php
//check whether food id is set or not
if (isset($_GET['food_id'])) {
    //get the food id and details of the selected food
    $food_id = $_GET['food_id'];

    //get the details of the selected food
    //sql query
    $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
    //execute the query
    $res = mysqli_query($conn, $sql);
    //count the rows
    $count = mysqli_num_rows($res);
    //check whether the data is available or not
    if ($count == 1) {
        //We have data
        //get the data from database
        $row = mysqli_fetch_assoc($res);

        $title = $row['title'];
        $price = $row['price'];
        $image_name = $row['image_name'];
    } else {
        //Food not available 
        //redirect to homepage
        header('location:' . SITEURL);
    }
} else {
    //redirect to homepage
    header('location:' . SITEURL);
}
?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search">
    <div class="container">

        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <form action="" class="order" method="POST">
            <fieldset>
                <legend>Selected Food</legend>


                <div class="food-menu-img">
                    <?php
                    //check whether image is available or not
                    if ($image_name == "") {
                        //image not avaialble
                        echo "<div class='error'>Image Not Available.</div>";
                    } else {
                        //image is available
                    ?>
                        <img src="<?php echo SITEURL?>images/Food/<?php echo $image_name;?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                    <?php

                    }
                    ?>
                </div>

                <div class="food-menu-desc">
                    <input type="hidden" name="food" value="<?php echo $title;?>">
                    <h3><?php echo $title; ?></h3>
                    <p class="food-price">$<?php echo $price; ?></p>
                    <input type="hiddem" name="price" value="<?php echo $price;?>">

                    <div class="order-label">Quantity</div>
                    <input type="number" name="quantity" class="input-responsive" value="1" required>

                </div>

            </fieldset>

            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. Saurabh Belwal" class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g. 94103xxxxx" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. saurabhblwl72@gmail.com" class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>

        </form>
        <?php
            //check whether submit button is clicked or not
            if(isset($_POST['submit']))
            {
                //get all the details from the form
                $food=$_POST['food'];
                $price=$_POST['price'];
                $quantity=$_POST['quantity'];
                $total=$price * $quantity;//total is equals to price into quantity

                $order_date = date("y-m-d h:i:sa");//order date
                
                $status= "Ordered";//Ordered , On Delievery, delieverd, cancel

                $customer_name=$_POST['full-name'];

                $customer_contact=$_POST['contact'];

                $customer_email=$_POST['email'];

                $customer_address=$_POST['address'];

                //save the order
                //create sql to save data in database
                $sql2="INSERT INTO tbl_order SET 
                    food= '$food',
                    price=$price,
                    quantity='$quantity',
                    total='$total',
                    order_date='$order_date',
                    status='$status',
                    customer_name='$customer_name',
                    customer_contact='$customer_contact',
                    customer_email='$customer_email',
                    customer_address='$customer_address'
                ";

                //execute the query
                $res2=mysqli_query($conn,$sql2);

                //check whether query executed successfully or not
                if($res2==true)
                {
                    //query executed and order saved
                    $_SESSION['order']="<div class='success text-center'>Food Order Placed Successfully.</div>";
                    header('location:'.SITEURL);
                }
                else{
                //failed to save order
                $_SESSION['order'] = "<div class='error text-center'>Failed To Order Food.</div>";
                header('location:' . SITEURL);
                }
            }
        ?>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<?php include('partial-front/footer.php'); ?>