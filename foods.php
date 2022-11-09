<?php include('partial-front/menu.php'); ?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <form action="<?php echo SITEURL?>food-search.php" method="GET">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->



<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        //display food that are active
        //Sql query
        $sql = "SELECT* FROM tbl_food WHERE active='yes'";

        //execute the query
        $res = mysqli_query($conn, $sql);
        //count rows
        $count = mysqli_num_rows($res);
        //check whether the food are available or not
        if ($count > 0) {
            //food available
            while ($row = mysqli_fetch_assoc($res)) {
                //get the values 
                $id = $row['id'];
                $title = $row['title'];
                $description = $row['description'];
                $price = $row['price'];
                $image_name = $row['image_name'];
        ?>

                <div class="food-menu-box">
                    <?php
                    //check whether image is available or not
                    if ($image_name == " ") {
                        //image not available
                        echo "<div class='error'>Image Not Available.</div>";
                    } else {
                    ?>
                        <div class="food-menu-img">
                            <img src="<?php echo SITEURL ?>images/Food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">

                        <?php
                    }
                        ?>
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p class="food-price">$<?php echo $price; ?></p>
                            <p class="food-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>

                            <a href="<?php echo SITEURL?>order.php?food_id=<?php echo $id;?>" class="btn btn-primary">Order Now</a>
                        </div>
                </div>
<?php
            }
        } else {
            //food not available
            echo "<div class='error'>Food Not Found.</div>";
        }
?>

<div class="clearfix"></div>



</div>

</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partial-front/footer.php'); ?>