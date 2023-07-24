<?php include "partials/menu.php" ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
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
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
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
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include "partials/footer.php" ?>

<?php

//check whether the submit button clicked or not
if (isset($_POST["submit"])) {

    // echo clicked
    //1. Get the Value From Category Form
    $title = $_POST["title"];

    //For radio input , We need to check the button is Selected or Not
    if (isset($_POST["featured"])) {

        //Get the Value from the form
        $featured = $_POST["featured"];
    } else {

        //Set the Default Value
        $featured = "No";
    }
    if (isset($_POST["active"])) {

        //Get the Value from the form
        $active = $_POST["active"];
    } else {

        //Set the Default Value
        $active = "No";
    }

    //check whether the image is selected or not and set the value for image name
    if (isset($_FILES["image"]["name"])) {

        //TO Upload image we need image name, source and destination name
        $image_name = $_FILES["image"]["name"];

        //Upload the image only if image is selected
        if ($image_name != "") {
            //Auto Rename our image
            //Get the Extention of our image name (jpg, png, gif,etc) e.g "special.food1.jpg"
            $ext = end(explode('.', $image_name));

            //Rename the image
            $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext;

            $source_path = $_FILES["image"]["tmp_name"];

            $destination_path = "../images/category/" . $image_name;

            //Finally Upload the Image
            $upload = move_uploaded_file($source_path, $destination_path);

            //check whether the image uploaded or not
            if ($image_name == false) {

                //Set massage
                $_SESSION["upload"] = "<div class='error'>Failed TO Upload Image</div>";

                //Redirect to Add Category Page
                header("location:" . $siteurl . "admin/add-category.php");

                //Stop the Process
                die();
            }
        } else {

            //Don't Upload Image and set the image_name as blank
            $image_name = "";
        }
    }

    //2. Create SQL Query to Insert Category into Database

    $sql = "INSERT INTO `tbl_category`(`title`, `image_name`, `featured`, `active`) VALUES ('$title', '$image_name' ,'$featured','$active')";

    //3. Execute the Query and Save in Database

    $result = mysqli_query($conn, $sql);

    //4. check whether the query Executed or not and data added or not

    if ($result == true) {

        //Query Executed and Category Added
        //Create a Session Variables to Display Massage
        $_SESSION["add"] = "<div class='success'>Category Added Successfully</div>";
        //Redirect pags to Manage Admin
        header("location:" . $siteurl . "admin/manage-category.php");
    } else {

        //Failed to Add Category
        //Create a Session Variables to Display Massage
        $_SESSION["add"] = "<div class='error'>Failed TO Add Category</div>";
        //Redirect pags to Add Admin
        header("location:" . $siteurl . "admin/add-category.php");
    }
}

?>