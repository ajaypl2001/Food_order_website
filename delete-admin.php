<link rel="stylesheet" href="../css/admin.css">
<?php
//Include dbconnet
include "partials/dbconnect.php";

//1. Get the ID of admin to be deleted
$id = $_GET["id"];

// Create SQL Query to Delete Admin 
$sql = "DELETE FROM `tbl_admin` WHERE id = $id";

//Execute the Query
$result = mysqli_query($conn,$sql);

//Check where the Query executed successfully or not
if($result == true){
    //Admin Deleted
    //Create Session Variable to Display Massege
    $_SESSION["delete"] = "<div class='success'>Admin Deleted Successfully</div>";

    //Redirect to Manage Admin Page with massage(success/error)
    header("location:".$siteurl."admin/manage-admin.php");
}
else{
    //Failed to Delete Admin
    $_SESSION["delete"] = "<div class='error'>Failed to Delete Admin. Try agin to Later.<div>";

    //Redirect to Manage Admin Page with massage(success/error)
    header("location:".$siteurl."admin/manage-admin.php");
}

?>