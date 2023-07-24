<?php include "partials/menu.php" ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>

        <?php

        //Get the ID of Selected Admin
        $id = $_GET["id"];

        //Create SQL Query to Get the Detail
        $sql1 = "SELECT * FROM tbl_admin Where id=$id";

        //Execute the Query
        $result1 = mysqli_query($conn, $sql1);

        //Check whether the Query is Executed or not
        if ($result1 == true) {

            //Check the Data Available or not
            $num = mysqli_num_rows($result1);

            //Check whether we have admin data or not
            if ($num == 1) {

                //Get the Details
                $rows = mysqli_fetch_assoc($result1);

                $full_name = $rows["full_name"];
                $username = $rows["username"];
            } else {

                //Redirect to Manage Admin Page
                header("location:" . $siteurl . "admin/manage-admin.php");
            }
        }

        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>
                <tr>
                    <td class="colspan-2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Addmin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php

//check whether the submit button is clicked or not
if (isset($_POST["submit"])) {

    //Get all the value from form to update
    $id = $_POST["id"];
    $full_name = $_POST["full_name"];
    $username = $_POST["username"];

    if ($full_name != "" && $username != "") {
        //Create a Sql Query to Update Admin
        $sql2 = "UPDATE `tbl_admin` SET `full_name`='$full_name',`username`='$username' WHERE id = $id";
    
        //Execute the Query
        $result2 = mysqli_query($conn, $sql2);
    
        if ($result2 == true) {
            //Admin Update
            //Create Session Variable to Display Massege
            $_SESSION["update"] = "<div class='success'>Admin updated Successfully</div>";
    
            //Redirect to Manage Admin Page with massage(success/error)
            header("location:" . $siteurl . "admin/manage-admin.php");
        } else {
            //Failed to Delete Admin
            $_SESSION["update"] = "<div class='error'>Failed to updated Admin. Try agin to Later.<div>";
    
            //Redirect to Manage Admin Page with massage(success/error)
            header("location:" . $siteurl . "admin/manage-admin.php");
        }
    }
    else {
        echo "Inpute filled is required";
    }

}

?>

<?php include "partials/footer.php" ?>