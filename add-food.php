<?php include "partials/menu.php" ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <?php

        if (isset($_SESSION["add"])) {
            echo $_SESSION["add"];
            unset($_SESSION["add"]);
            echo "<br><br>";
        }

        if (isset($_SESSION["upload"])) {
            echo $_SESSION["upload"];
            unset($_SESSION["upload"]);
            echo "<br><br>";
        }

        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the food">
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea type="text" cols="40" rows="5" name="description" placeholder="Description of the food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">

                            <?php

                            //Create php code to display categories from data base
                            //1. Create SQL to get all active categories from database
                            $sql = "SELECT * FROM `tbl_category` WHERE active = 'Yes'";

                            //Execute Query
                            $result = mysqli_query($conn, $sql);

                            //Count rows to Check whether we have categorise or not 
                            $count = mysqli_num_rows($result);

                            //If count is greater then zero , we have categories else we don't have category
                            if ($count > 0) {

                                //we have categorise 
                                while ($row = mysqli_fetch_assoc($result)) {

                                    //Get details of category
                                    $id = $row['id'];
                                    $title = $row['title'];
                            ?>

                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                <?php
                                }
                            } else {

                                //we don't have categorise
                                ?>

                                <option value="0">No Category Found</option>

                            <?php
                            }

                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td class="colspan-2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        //process the value from the form and save it in database
        //check whether the submit button clicked or not
        if (isset($_POST["submit"])) {
            //Add the Food in database
            //1. Get the data from form

            $title = $_POST["title"];
            $description = $_POST["description"];
            $price = $_POST["price"];
            $category = $_POST["category"];

            //Check whether the radio button for featured and active checked or not
            if (isset($_POST["featured"])) {
                $featured = $_POST["featured"];
            } else {
                $featured = "No"; //setting the default value
            }

            if (isset($_POST["active"])) {
                $active = $_POST["active"];
            } else {
                $active = "No"; //setting the default value
            }

            //2. Upload the image if selected
            //Check whether the select image clicked or not and upload the image only if the image is selected
            if (isset($_FILES['image']['name'])) {

                //Get the details of the selected image
                $image_name = $_FILES['image']['name'];

                //Check whether the image selected or not and upload the image if selected
                if ($image_name != "") {
                    //Auto Rename our image
                    //Get the Extention of our image name (jpg, png, gif,etc) e.g "Food-/name.jpg"
                    $ext = end(explode('.', $image_name));

                    //Rename the image
                    $image_name = "Food_Name_" . rand(000, 999) . '.' . $ext;

                    $source_path = $_FILES["image"]["tmp_name"];

                    $destination_path = "../images/food/" . $image_name;

                    //Finally Upload the Image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    //check whether the image uploaded or not
                    if ($image_name == false) {

                        //Set massage
                        $_SESSION["upload"] = "<div class='error'>Failed TO Upload Image</div>";

                        //Redirect to Add Category Page
                        header("location:" . $siteurl . "admin/add-food.php");

                        //Stop the Process
                        die();
                    }
                } else {

                    $image_name = ""; //setting default value as a blank
                }
            } else {

                $image_name = ""; //setting default value as a blank
            }



            //3. Sql Query to Save the Data into Database
            $sql2 = "INSERT INTO `tbl_food`(`title`, `description`, `price`, `image_name`, `category_id`, `featured`, `active`) VALUES ('$title','$description','$price','$image_name','$category','$featured','$active')";

            //4. Execute Query to Data into Database
            $result2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn, $sql2));

            //5. check whether the (Query is Exquited) Data is Inserted or Not display appropriate massage
            if ($result2 == true) {
                //Data Inserted
                // echo "Data Insrted";
                //Create a Session Variables to Display Massage
                $_SESSION["add"] = "<div class='success'>Food Added Successfully</div>";
                //Redirect pags to Manage Admin
                header("location:" . $siteurl . "admin/manage-food.php");
            } else {
                //Failed To Insert Data
                // echo "Failed to Insert Data";
                //Create a Session Variables to Display Massage
                $_SESSION["add"] = "<div class='error'>Failed TO Add Admin</div>";
                //Redirect pags to Add Admin
                header("location:" . $siteurl . "admin/add-food.php");
            }
        }

        ?>

    </div>
</div>

<?php include "partials/footer.php" ?>