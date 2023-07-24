<?php include "partials/menu.php"; ?>

<!-- Main Content Section starts -->
<div class="main-content ">
    <div class="wrapper">
        <h1>Manage Food</h1>
        <br><br>

        <?php

        if (isset($_SESSION["add"])) {
            echo $_SESSION["add"];
            unset($_SESSION["add"]);
            echo "<br><br>";
        }

        if (isset($_SESSION["remove"])) {
            echo $_SESSION["remove"];
            unset($_SESSION["remove"]);
            echo "<br><br>";
        }

        if (isset($_SESSION["delete"])) {
            echo $_SESSION["delete"];
            unset($_SESSION["delete"]);
            echo "<br><br>";
        }

        if (isset($_SESSION["no-food-found"])) {
            echo $_SESSION["no-food-found"];
            unset($_SESSION["no-food-found"]);
            echo "<br><br>";
        }

        if (isset($_SESSION["updated"])) {
            echo $_SESSION["updated"];
            unset($_SESSION["updated"]);
            echo "<br><br>";
        }

        if (isset($_SESSION["upload"])) {
            echo $_SESSION["upload"];
            unset($_SESSION["upload"]);
            echo "<br><br>";
        }

        if (isset($_SESSION["failed_remove"])) {
            echo $_SESSION["failed_remove"];
            unset($_SESSION["failed_remove"]);
            echo "<br><br>";
        }

        ?>

        <a href="<?php echo $siteurl ?>admin/add-food.php" class="btn-primary">Add Food</a>
        <br><br>

        <table class="tbl-full">
            <tr>
                <th>S.No.</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php

            //Query to Get all Food from Database
            $sql = "SELECT * FROM `tbl_food`";

            //Execute Query
            $result = mysqli_query($conn, $sql);

            //count rows 
            $count = mysqli_num_rows($result);

            //check whether we have Data in Database or Not
            if ($count > 0) {

                //we have data in database
                //Get the data and display
                $sno = 0;
                while ($row = mysqli_fetch_assoc($result)) {

                    $sno += 1;
                    $id = $row["id"];
                    $title = $row["title"];
                    $price = $row["price"];
                    $image_name = $row["image_name"];
                    $featured = $row["featured"];
                    $active = $row["active"];

            ?>
                    <tr>
                        <td><?php echo $sno ?></td>
                        <td><?php echo $title ?></td>
                        <td><?php echo $price ?></td>

                        <td>
                            <?php

                            //check whether image name is available or not
                            if ($image_name != "") {

                                //display the image
                            ?>

                                <img src="<?php echo $siteurl; ?>images/food/<?php echo $image_name; ?>" width="100px">

                            <?php
                            } else {
                                //display the massage 
                                echo "<div class='error'>Image Not Added.</div>";
                            }

                            ?>
                        </td>

                        <td><?php echo  $featured ?></td>
                        <td><?php echo $active ?></td>
                        <td>
                            <a href="<?php $siteurl; ?>update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a>
                            <a href="<?php $siteurl; ?>delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class='btn-danger'>Delete Food</a>
                        </td>
                    </tr>
                <?php
                }
            } else {

                //we don't have data
                //we will display the massage inside the table
                ?>

                <tr>
                    <td colspan="6">
                        <div class="error">No Food Added.</div>
                    </td>
                </tr>

            <?php
            }

            ?>

        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include "partials/footer.php"; ?>