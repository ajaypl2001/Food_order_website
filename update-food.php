<?php include "partials/menu.php" ?>

<div class="wrapper">
    <h1>Update Food</h1>
    <br><br>

    <?php

    //Check whether the id is set or not
    if (isset($_GET["id"])) {

        //Get the Id and all other Details
        $id = $_GET["id"];

        //Create SQL Query to get all other Details
        $sql = "SELECT * FROM `tbl_food` WHERE id = '$id'";

        //Execute the query
        $result = mysqli_query($conn, $sql);

        //Count the Rows to Check whether the id valid or not
        $count = mysqli_num_rows($result);

        if ($count == 1) {

            //Get all Data
            $row = mysqli_fetch_assoc($result);

            $id = $row["id"];
            $title = $row["title"];
            $description = $row["description"];
            $price = $row["price"];
            $current_image = $row["image_name"];
            $featured = $row["featured"];
            $active = $row["active"];
        } else {

            //Redirect to massage Category with session massage
            $_SESSION["no-food-found"] = "<div class='error'>Food not Found.</div>";
            header("location:" . $siteurl . "admin/manage-food.php");
        }
    } else {

        //Redirect to Manage Category 
        header("location:" . $siteurl . "admin/manage-food.php");
    }

    ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Title:</td>
                <td>
                    <input type="text" name="title" value="<?php echo $title ?>">
                </td>
            </tr>
            <tr>
                <td>Description:</td>
                <td>
                    <textarea cols="40" rows="5" type="text" name="description"><?php echo $description ?></textarea>
                </td>
            </tr>
            <tr>
                <td>Price:</td>
                <td>
                    <input type="text" name="price" value="<?php echo $price ?>">
                </td>
            </tr>
            <tr>
                <td>Current Image:</td>
                <td>

                    <?php
                    if ($current_image != "") {
                        //Display Image
                    ?>
                        <img src="<?php echo $siteurl ?>images/food/<?php echo $current_image ?>" width="100px">
                    <?php
                    } else {
                        //Display Massage
                        echo "<div class='error'>Image not Added.</div>";
                    }
                    ?>

                </td>
            </tr>
            <tr>
                <td>Update Image:</td>
                <td>
                    <input type="file" name="update_image" value="">
                </td>
            </tr>
            <tr>
                <td>Featured:</td>
                <td>
                    <input <?php if ($featured == "Yes") {
                                echo 'checked';
                            } ?> type="radio" name="featured" value="Yes"> Yes
                    <input <?php if ($featured == "No") {
                                echo 'checked';
                            } ?> type="radio" name="featured" value="No"> No
                </td>
            </tr>
            <tr>
                <td>Active:</td>
                <td>
                    <input <?php if ($active == "Yes") {
                                echo 'checked';
                            } ?> type="radio" name="active" value="Yes"> Yes
                    <input <?php if ($active == "No") {
                                echo 'checked';
                            } ?> type="radio" name="active" value="No"> No
                </td>
            </tr>
            <tr>
                <td class="colspan-2">
                    <input type="hidden" name="current_image" value="<?php echo $current_image ?>">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                </td>
            </tr>
        </table>
    </form>

    <?php

    if (isset($_POST['submit'])) {

        //1. Get all values from our form
        $id = $_POST["id"];
        $title = $_POST["title"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $current_image = $_POST["current_image"];
        $featured = $_POST["featured"];
        $active = $_POST["active"];

        //2. Updating new Image if Selected
        //Check whether the image selected or not
        if (isset($_FILES["update_image"]["name"])) {

            //Get the Image Details
            $image_name = $_FILES["update_image"]["name"];

            //Check whether the image is available or not
            if ($image_name != "") {

                //image available
                //A. Upload the new image
                //Auto Rename our image
                //Get the Extention of our image name (jpg, png, gif,etc) e.g "special.food1.jpg"
                $ext = end(explode('.', $image_name));

                //Rename the image
                $image_name = "Food_Name_" . rand(000, 999) . '.' . $ext;

                $source_path = $_FILES["update_image"]["tmp_name"];

                $destination_path = "../images/food/" . $image_name;

                //Finally Upload the Image
                $upload = move_uploaded_file($source_path, $destination_path);

                //check whether the image uploaded or not
                if ($upload == false) {

                    //Set massage
                    $_SESSION["upload"] = "<div class='error'>Failed TO Upload Image</div>";

                    //Redirect to Add Category Page
                    header("location:" . $siteurl . "admin/manage-food.php");

                    //Stop the Process
                    die();
                }

                //B. Remove the Current Image
                if ($current_image != "") {
                    $remove_path = "../images/food/" . $current_image;
                    $remove = unlink($remove_path);

                    //Check whether the current image removed or not
                    //And if Failed to removed then Display Massage and stop the process
                    if ($remove == false) {

                        //Set massage
                        $_SESSION["failed_remove"] = "<div class='error'>Failed TO Remove Current Image</div>";

                        //Redirect to Add Food Page
                        header("location:" . $siteurl . "admin/manage-food.php");

                        //Stop the Process
                        die();
                    }
                }
            } else {
                $image_name = $current_image;//Default image when image is not selected
            }
        } else {
            $image_name = $current_image;//Default image when button is not clicked
        }


        //3. Update the Database
        $sql2 = "UPDATE `tbl_food` SET `title`='$title',`description`='$description',`price`='$price',`image_name`='$image_name',`featured`='$featured',`active`='$active' WHERE id='$id'";

        //Execute Query
        $result2 = mysqli_query($conn, $sql2);

        //3. Redirect to manage food with massage
        // Check whether Executed or not
        if ($result2 == true) {

            //Food Updated
            $_SESSION['updated'] = "<div class='success'>Food Updated Successfully.</div>";

            //Redirect to Manage Category
            header("location:" . $siteurl . "admin/manage-food.php");
        } else {

            //Failed to Update Category
            $_SESSION['updated'] = "<div class='error'>Failed to Updated Food.</div>";

            //Redirect to Manage Category
            header("location:" . $siteurl . "admin/manage-food.php");
        }
    }
    ?>

</div>

<?php include "partials/footer.php" ?>