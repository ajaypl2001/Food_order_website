<link rel="stylesheet" href="../css/admin.css">
<?php
//Include dbconnect file
include "partials/dbconnect.php";

//Check whether the id and image_name value set or not
if(isset($_GET["id"]) && isset($_GET["image_name"])){

    //Get the value and Delete
    $id = $_GET["id"];
    $image_name = $_GET["image_name"];
   
    //Remove the physical image file is available
    if($image_name != ""){

        //Image is available, so remove it 
        $path = "../images/category/".$image_name;

        //Remove the image 
        $remove = unlink($path);

        //If failed to remove image then add the error massage and stop the process
        if($remove == false){

            //set the session massage
            $_SESSION["remove"] = "<div class='error'>Failed to Remove Category Image</div>";

            //Redirect to Manage Category Page
            header("location:".$siteurl."admin/manage-category.php");

            //stop the process
            die;

        }
    }

    //Delete Data from the database
    //SQL Query to Delete Data from the Database
    $sql = "DELETE FROM `tbl_category` WHERE id = '$id'";

    //Execute the Query 
    $result = mysqli_query($conn,$sql);
    //check whether the Data Delete from the Database or not
    if($result == true){
        
        //Set success massage and Redirect
        //set the session massage
        $_SESSION["delete"] = "<div class='success'>Category Deleted Successfully.</div>";

        //Redirect to Manage Category Page
        header("location:".$siteurl."admin/manage-category.php");

    }
    else{

        //Set fail massage and Redirect
        //set the session massage
        $_SESSION["delete"] = "<div class='error'>Failed to Delete Category</div>";

        //Redirect to Manage Category Page
        header("location:".$siteurl."admin/manage-category.php");

    }
}
else{

    //Redirect to Manage Category Page
    header("location:".$siteurl."admin/manage-category.php");
}

?>